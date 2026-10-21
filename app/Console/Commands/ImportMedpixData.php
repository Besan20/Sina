<?php

namespace App\Console\Commands;

use App\Models\MedpixCase;
use App\Models\MedpixImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportMedpixData extends Command
{
    protected $signature = 'medpix:import {--fresh : حذف البيانات القديمة أولاً}';
    protected $description = 'استيراد بيانات MedPix من ملفات JSON إلى جداول medpix_cases و medpix_images';

    private string $dataPath;
    private string $imagesPath;

    public function handle(): int
    {
        $this->dataPath = app_path('medpix');
        $this->imagesPath = $this->dataPath . '/images';
        $splittedPath = $this->dataPath . '/splitted_dataset';

        $this->info("📂 مسار البيانات: {$this->dataPath}");

        if (!is_dir($this->dataPath)) {
            $this->error("❌ المجلد غير موجود: {$this->dataPath}");
            return 1;
        }

        if (!is_dir($splittedPath)) {
            $this->error("❌ مجلد splitted_dataset غير موجود: {$splittedPath}");
            return 1;
        }

        if ($this->option('fresh')) {
            DB::table('medpix_images')->truncate();
            DB::table('medpix_cases')->truncate();
            $this->info('🗑️  تم حذف البيانات القديمة');
        }

        // ============ استيراد الحالات ============
        $this->info('📥 استيراد الحالات...');
        $cases = $this->loadCases($splittedPath);
        $this->info("📊 إجمالي الحالات: " . count($cases));

        if (empty($cases)) {
            $this->error("❌ لم يتم العثور على حالات. تحقق من ملفات data_*.jsonl");
            return 1;
        }

        $progress = $this->output->createProgressBar(count($cases));
        $progress->start();

        $inserted = 0;
        $updated = 0;

        foreach ($cases as $case) {
            $uid = $case['U_id'] ?? null;
            if (!$uid) {
                $progress->advance();
                continue;
            }

            $c = $case['Case'] ?? [];
            $t = $case['Topic'] ?? [];
            $history = $c['History'] ?? '';
            $exam = $c['Exam'] ?? '';

            $age = $this->extractAge($history) ?? $this->extractAge($exam);
            $gender = $this->extractGender($history) ?? $this->extractGender($exam);

            $data = [
                'uid' => $uid,
                'split' => $case['_split'] ?? 'train',
                'title' => $c['Title'] ?? null,
                'history' => $history,
                'exam' => $exam,
                'findings' => $c['Findings'] ?? null,
                'differential_diagnosis' => $c['Differential Diagnosis'] ?? null,
                'case_diagnosis' => $c['Case Diagnosis'] ?? null,
                'diagnosis_by' => $c['Diagnosis By'] ?? null,
                'treatment_followup' => $c['Treatment & Follow Up'] ?? null,
                'discussion' => $c['Discussion'] ?? null,
                'topic_title' => $t['Title'] ?? null,
                'disease_discussion' => $t['Disease Discussion'] ?? null,
                'acr_code' => $t['ACR Code'] ?? null,
                'category' => $t['Category'] ?? null,
                'keywords' => $t['Keywords'] ?? null,
                'reference_text' => $t['Reference'] ?? null,
                'patient_age' => $age,
                'patient_gender' => $gender ?? 'unknown',
                'ct_images_count' => count($case['TAC'] ?? []),
                'mri_images_count' => count($case['MRI'] ?? []),
                'is_published' => true,
            ];

            $existing = MedpixCase::where('uid', $uid)->first();
            if ($existing) {
                $existing->update($data);
                $updated++;
            } else {
                MedpixCase::create($data);
                $inserted++;
            }

            $progress->advance();
        }

        $progress->finish();
        $this->newLine();
        $this->info("✅ حالات جديدة: {$inserted}");
        $this->info("♻️  حالات محدّثة: {$updated}");

        // ============ استيراد الصور ============
        $this->info('📥 استيراد الصور...');
        $this->importImages();

        $this->newLine();
        $this->info('🎉 اكتمل الاستيراد بنجاح!');
        return 0;
    }

    private function loadCases(string $splittedPath): array
    {
        $allCases = [];
        $files = [
            'train' => $splittedPath . '/data_train.jsonl',
            'dev' => $splittedPath . '/data_dev.jsonl',
            'test' => $splittedPath . '/data_test.jsonl',
        ];

        foreach ($files as $split => $path) {
            if (!file_exists($path)) {
                $this->warn("⚠️  ملف غير موجود: {$path}");
                continue;
            }

            $handle = fopen($path, 'r');
            $count = 0;
            while (($line = fgets($handle)) !== false) {
                $line = trim($line);
                if (empty($line)) continue;

                $case = json_decode($line, true);
                if ($case && isset($case['U_id'])) {
                    $case['_split'] = $split;
                    $allCases[] = $case;
                    $count++;
                }
            }
            fclose($handle);
            $this->line("  ✓ {$split}: {$count} حالة");
        }

        return $allCases;
    }

    private function importImages(): void
    {
        $descriptionsFile = $this->dataPath . '/Descriptions.json';

        if (!file_exists($descriptionsFile)) {
            $this->warn("⚠️  الملف غير موجود: {$descriptionsFile}");
            return;
        }

        $this->info("📄 قراءة Descriptions.json ...");
        $descriptions = json_decode(file_get_contents($descriptionsFile), true);

        if (!is_array($descriptions)) {
            $this->error("❌ فشل في قراءة Descriptions.json");
            return;
        }

        $this->info("📊 إجمالي الصور: " . count($descriptions));

        DB::table('medpix_images')->truncate();

        $progress = $this->output->createProgressBar(count($descriptions));
        $progress->start();

        $batch = [];
        $order = [];
        $foundImages = 0;
        $missingImages = 0;

        foreach ($descriptions as $desc) {
            $uid = $desc['U_id'] ?? null;
            $imageName = $desc['image'] ?? null;
            if (!$uid || !$imageName) {
                $progress->advance();
                continue;
            }

            $order[$uid] = ($order[$uid] ?? 0) + 1;

            $imagePath = $this->findImagePath($imageName);
            if ($imagePath) {
                $foundImages++;
            } else {
                $missingImages++;
            }

            $d = $desc['Description'] ?? [];

            $batch[] = [
                'uid' => $uid,
                'image_name' => $imageName,
                'image_type' => $desc['Type'] ?? 'Other',
                'image_path' => $imagePath,
                'caption' => $d['Caption'] ?? null,
                'modality' => $d['Modality'] ?? null,
                'plane' => $d['Plane'] ?? null,
                'location' => $desc['Location'] ?? null,
                'location_category' => $desc['Location Category'] ?? null,
                'acr_codes' => $d['ACR Codes'] ?? null,
                'display_order' => $order[$uid],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($batch) >= 500) {
                DB::table('medpix_images')->insert($batch);
                $batch = [];
            }

            $progress->advance();
        }

        if (!empty($batch)) {
            DB::table('medpix_images')->insert($batch);
        }

        $progress->finish();
        $this->newLine();
        $this->info("✅ صور موجودة: {$foundImages}");
        if ($missingImages > 0) {
            $this->warn("⚠️  صور غير موجودة: {$missingImages}");
        }
    }

    private function findImagePath(string $imageName): ?string
    {
        $extensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp'];

        foreach ($extensions as $ext) {
            $path = $this->imagesPath . '/' . $imageName . $ext;
            if (file_exists($path)) {
                return 'medpix/images/' . $imageName . $ext;
            }
        }

        $uid = explode('_', $imageName)[0] ?? null;
        if ($uid) {
            foreach ($extensions as $ext) {
                $path = $this->imagesPath . '/' . $uid . '/' . $imageName . $ext;
                if (file_exists($path)) {
                    return 'medpix/images/' . $uid . '/' . $imageName . $ext;
                }
            }
        }

        return null;
    }

    private function extractAge(string $text): ?int
    {
        if (empty($text)) return null;

        $patterns = [
            '/(\d{1,3})[\s-]*(?:year|yr)s?[\s-]*old/i',
            '/(\d{1,3})\s*yo\b/i',
            '/(\d{1,3})\s*y\.?o\.?/i',
            '/(\d{1,3})\s*y\/o/i',
        ];

        foreach ($patterns as $p) {
            if (preg_match($p, $text, $m)) {
                $age = (int)$m[1];
                if ($age > 0 && $age < 120) return $age;
            }
        }
        return null;
    }

    private function extractGender(string $text): ?string
    {
        if (empty($text)) return null;

        $t = strtolower($text);
        if (preg_match('/\b(male|man|men|boy|gentleman|mr\.?|yo m|y\/o m)\b/', $t)) {
            return 'male';
        }
        if (preg_match('/\b(female|woman|women|girl|lady|mrs\.?|ms\.?|yo f|y\/o f)\b/', $t)) {
            return 'female';
        }
        return null;
    }
}