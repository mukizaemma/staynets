<?php

namespace App\Services;

class StayPricingService
{
    /**
     * Compute which rate applies and the base total.
     *
     * Rules:
     * - nights < 7: daily rate (nightly * nights)
     * - nights >= 7: weekly rate (weekly * ceil(nights/7)) if enabled and provided; else daily
     * - nights >= 30: monthly rate (monthly * ceil(nights/30)) if enabled and provided; else fall back to weekly/daily
     *
     * @return array{rate_type:string,units:int,unit_price:float,base_total:float,label:string}
     */
    public static function compute(
        int $nights,
        float $dailyRate,
        ?float $weeklyRate,
        bool $weeklyEnabled,
        ?float $monthlyRate,
        bool $monthlyEnabled,
    ): array {
        $n = max(0, $nights);
        $daily = max(0.0, (float) $dailyRate);
        $weekly = $weeklyRate !== null ? max(0.0, (float) $weeklyRate) : 0.0;
        $monthly = $monthlyRate !== null ? max(0.0, (float) $monthlyRate) : 0.0;

        if ($n >= 30 && $monthlyEnabled && $monthly > 0) {
            $months = (int) ceil($n / 30);
            return [
                'rate_type' => 'monthly',
                'units' => max(1, $months),
                'unit_price' => $monthly,
                'base_total' => $monthly * max(1, $months),
                'label' => 'Monthly rate',
            ];
        }

        if ($n >= 7 && $weeklyEnabled && $weekly > 0) {
            $weeks = (int) ceil($n / 7);
            return [
                'rate_type' => 'weekly',
                'units' => max(1, $weeks),
                'unit_price' => $weekly,
                'base_total' => $weekly * max(1, $weeks),
                'label' => 'Weekly rate',
            ];
        }

        return [
            'rate_type' => 'daily',
            'units' => $n,
            'unit_price' => $daily,
            'base_total' => $daily * $n,
            'label' => 'Daily rate',
        ];
    }
}

