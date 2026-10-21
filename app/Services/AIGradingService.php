<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIGradingService
{
    private ?string $groqKey;
    private ?string $geminiKey;
    private string $groqUrl = 'https://api.groq.com/openai/v1';
    private string $geminiUrl = 'https://generativelanguage.googleapis.com/v1beta';
    private string $groqModel = 'openai/gpt-oss-120b';
    private string $geminiModel = 'gemini-2.5-flash';

    public function __construct()
    {
        $this->groqKey = config('services.groq.key');
        $this->geminiKey = config('services.gemini.key');
    }

    // ============================================
    // تقييم التشخيص
    // ============================================
    public function evaluateDiagnosis(string $userDiagnosis, string $correctDiagnosis, array $context = []): array
    {
        $prompt = $this->buildDiagnosisPrompt($userDiagnosis, $correctDiagnosis, $context);

        // 1. جرّب Groq
        if ($this->groqKey) {
            $result = $this->callGroq($prompt);
            if ($result['success']) {
                $parsed = $this->parseDiagnosisResponse($result['text']);
                if ($parsed['success']) {
                    $parsed['provider'] = 'groq';
                    return $parsed;
                }
            }
        }

        // 2. Fallback: Gemini
        if ($this->geminiKey) {
            $result = $this->callGemini($prompt);
            if ($result['success']) {
                $parsed = $this->parseDiagnosisResponse($result['text']);
                if ($parsed['success']) {
                    $parsed['provider'] = 'gemini';
                    return $parsed;
                }
            }
        }

        // 3. Fallback نهائي: Keyword Matching
        return [
            'success' => false,
            'is_correct' => $this->keywordMatch($userDiagnosis, $correctDiagnosis),
            'confidence' => 50,
            'reason' => 'AI unavailable, used keyword matching',
            'feedback' => 'Evaluation completed with basic matching.',
            'provider' => 'keyword',
        ];
    }

    // ============================================
    // بناء Prompt
    // ============================================
    private function buildDiagnosisPrompt(string $userDiagnosis, string $correctDiagnosis, array $context): string
    {
        $history = $context['history'] ?? 'Not available';
        $findings = $context['findings'] ?? 'Not available';

        return <<<PROMPT
You are a medical education evaluator for medical students. Evaluate the student's diagnosis compared to the correct diagnosis. Accept variations, synonyms, abbreviations, and different phrasings that convey the SAME medical meaning.

CASE HISTORY:
{$history}

FINDINGS:
{$findings}

CORRECT DIAGNOSIS:
{$correctDiagnosis}

STUDENT'S DIAGNOSIS:
{$userDiagnosis}

Evaluation criteria:
- Mark CORRECT if the student's diagnosis conveys the same medical meaning, even with different wording, abbreviations, or synonyms.
- Example: "Hyperglycemic hemiballismus" = "Nonketotic Hyperglycemic Hemichorea/Hemiballismus" ✅
- Example: "PE" = "Pulmonary Embolism" ✅
- Example: "MI" = "Myocardial Infarction" ✅
- Minor spelling mistakes should NOT affect the result.

Return ONLY valid JSON (no markdown, no code blocks):
{
    "is_correct": true/false,
    "confidence": 0-100,
    "reason": "Brief reason in one sentence",
    "feedback": "Encouraging feedback for the student (2-3 sentences)"
}
PROMPT;
    }

    // ============================================
    // استدعاء Groq API
    // ============================================
    private function callGroq(string $prompt): array
    {
        try {
            $response = Http::timeout(30)
                ->withToken($this->groqKey)
                ->post("{$this->groqUrl}/chat/completions", [
                    'model' => $this->groqModel,
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a medical evaluator. Return only valid JSON.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.2,
                    'max_tokens' => 1024,
                    'response_format' => ['type' => 'json_object'],
                ]);

            if (!$response->successful()) {
                Log::warning('Groq API error', ['status' => $response->status(), 'body' => $response->body()]);
                return ['success' => false, 'error' => "HTTP {$response->status()}"];
            }

            $data = $response->json();
            $text = $data['choices'][0]['message']['content'] ?? null;

            return $text ? ['success' => true, 'text' => $text] : ['success' => false];

        } catch (\Exception $e) {
            Log::error('Groq exception', ['message' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // ============================================
    // استدعاء Gemini API
    // ============================================
    private function callGemini(string $prompt): array
    {
        try {
            $url = "{$this->geminiUrl}/models/{$this->geminiModel}:generateContent?key={$this->geminiKey}";

            $response = Http::timeout(30)->post($url, [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ],
                'generationConfig' => [
                    'temperature' => 0.2,
                    'maxOutputTokens' => 1024,
                    'responseMimeType' => 'application/json',
                ],
            ]);

            if (!$response->successful()) {
                Log::warning('Gemini API error', ['status' => $response->status(), 'body' => $response->body()]);
                return ['success' => false, 'error' => "HTTP {$response->status()}"];
            }

            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

            return $text ? ['success' => true, 'text' => $text] : ['success' => false];

        } catch (\Exception $e) {
            Log::error('Gemini exception', ['message' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // ============================================
    // Parse Response
    // ============================================
    private function parseDiagnosisResponse(string $text): array
    {
        $text = preg_replace('/```json\s*/', '', $text);
        $text = preg_replace('/```\s*/', '', $text);
        $text = trim($text);

        $start = strpos($text, '{');
        $end = strrpos($text, '}');

        if ($start === false || $end === false) {
            return ['success' => false];
        }

        $json = substr($text, $start, $end - $start + 1);
        $decoded = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($decoded['is_correct'])) {
            return ['success' => false];
        }

        return [
            'success' => true,
            'is_correct' => (bool) $decoded['is_correct'],
            'confidence' => (int) ($decoded['confidence'] ?? 0),
            'reason' => $decoded['reason'] ?? '',
            'feedback' => $decoded['feedback'] ?? '',
        ];
    }

    // ============================================
    // Keyword Matching (Fallback)
    // ============================================
    private function keywordMatch(string $user, string $correct): bool
    {
        $userLower = strtolower(trim($user));
        $correctLower = strtolower(trim($correct));

        if (empty($userLower) || empty($correctLower)) return false;
        if ($userLower === $correctLower) return true;

        $keywords = preg_split('/[\s,;\/]+/', $correctLower);
        $keywords = array_filter($keywords, fn($w) => strlen($w) > 3);

        $matchCount = 0;
        foreach ($keywords as $keyword) {
            if (str_contains($userLower, $keyword)) $matchCount++;
        }

        return $matchCount >= 2 || ($matchCount >= 1 && count($keywords) <= 2);
    }
}