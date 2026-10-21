{{-- resources/views/components/xp-bar.blade.php --}}
<div class="xp-bar-wrapper">
    {{-- Level Badge --}}
    <div class="xp-bar__level">
        <div class="xp-bar__level-circle">
            <span class="xp-bar__level-number">{{ $level }}</span>
        </div>
        <div class="xp-bar__level-info">
            <span class="xp-bar__level-title">{{ $levelTitle }}</span>
            <span class="xp-bar__level-sub">{{ number_format($totalPoints) }} pts</span>
        </div>
    </div>

    {{-- XP Progress --}}
    <div class="xp-bar__progress">
        <div class="xp-bar__progress-info">
            <span class="xp-bar__progress-label">XP</span>
            <span class="xp-bar__progress-value">{{ $xpInLevel }} / {{ $xpNeeded }}</span>
        </div>
        <div class="xp-bar__progress-track">
            <div class="xp-bar__progress-fill" style="width: {{ $percentage }}%;"></div>
        </div>
    </div>

    {{-- Streak --}}
    @if($streak > 0)
        <div class="xp-bar__streak" title="Day Streak">
            <span class="material-symbols-outlined">local_fire_department</span>
            <span class="xp-bar__streak-value">{{ $streak }}</span>
        </div>
    @endif
</div>

<style>
    .xp-bar-wrapper {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 6px 14px;
        background: rgba(0, 180, 216, 0.05);
        border-radius: var(--radius-full);
        border: 1px solid rgba(0, 180, 216, 0.1);
        transition: all 0.3s ease;
    }

    .dark .xp-bar-wrapper {
        background: rgba(0, 180, 216, 0.08);
        border-color: rgba(0, 180, 216, 0.15);
    }

    /* Level */
    .xp-bar__level {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .xp-bar__level-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--color-primary-teal), #0a8ba8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 800;
        font-size: 0.85rem;
        box-shadow: 0 2px 8px rgba(0, 180, 216, 0.3);
        flex-shrink: 0;
    }

    .xp-bar__level-info {
        display: flex;
        flex-direction: column;
        line-height: 1.1;
    }

    .xp-bar__level-title {
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--color-primary-teal);
        white-space: nowrap;
    }

    .dark .xp-bar__level-title {
        color: #5dd0e8;
    }

    .xp-bar__level-sub {
        font-size: 0.6rem;
        color: var(--color-text-muted);
        font-weight: 600;
    }

    /* Progress Bar */
    .xp-bar__progress {
        display: flex;
        flex-direction: column;
        gap: 2px;
        min-width: 120px;
    }

    .xp-bar__progress-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.6rem;
        font-weight: 700;
        color: var(--color-text-secondary);
    }

    .xp-bar__progress-label {
        color: var(--color-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .xp-bar__progress-value {
        color: var(--color-primary-teal);
    }

    .dark .xp-bar__progress-value {
        color: #5dd0e8;
    }

    .xp-bar__progress-track {
        height: 4px;
        background: rgba(0, 0, 0, 0.06);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .dark .xp-bar__progress-track {
        background: rgba(255, 255, 255, 0.08);
    }

    .xp-bar__progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--color-primary-teal), #0a8ba8);
        border-radius: var(--radius-full);
        transition: width 0.8s ease;
        box-shadow: 0 0 8px rgba(0, 180, 216, 0.4);
    }

    /* Streak */
    .xp-bar__streak {
        display: flex;
        align-items: center;
        gap: 2px;
        padding: 4px 10px;
        background: linear-gradient(135deg, rgba(253, 203, 110, 0.15), rgba(230, 126, 34, 0.15));
        border-radius: var(--radius-full);
        border: 1px solid rgba(230, 126, 34, 0.2);
    }

    .xp-bar__streak .material-symbols-outlined {
        font-size: 1.1rem;
        color: #e67e22;
    }

    .xp-bar__streak-value {
        font-size: 0.75rem;
        font-weight: 800;
        color: #e67e22;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .xp-bar__progress {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .xp-bar-wrapper {
            padding: 4px 10px;
            gap: 8px;
        }

        .xp-bar__level-info {
            display: none;
        }

        .xp-bar__level-circle {
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }
    }
</style>