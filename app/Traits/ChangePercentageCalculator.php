<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait ChangePercentageCalculator
{
    /**
     * Calculate the percentage change for a given relationship query.
     */
    public function calculatePercentageChange(HasMany $relationshipQuery): float
    {
        // Define time periods
        [$recentPeriodStart, $currentDate, $previousPeriodStart] = $this->defineTimePeriods();

        // Count entities in each period
        $recentCount = $relationshipQuery
            ->whereBetween('created_at', [$recentPeriodStart, $currentDate])
            ->count();

        $previousCount = $relationshipQuery
            ->whereBetween('created_at', [$previousPeriodStart, $recentPeriodStart])
            ->count();

        // Prevent division by zero and calculate percentage change
        if ($previousCount === 0) {
            return $recentCount > 0 ? 100.0 : 0.0;
        }

        $percentageChange = (($recentCount - $previousCount) / $previousCount) * 100;

        return round($percentageChange, 2); // Round to 2 decimal places
    }

    /**
     * Define and return key time periods for percentage calculations.
     */
    private function defineTimePeriods(): array
    {
        $currentDate = now();
        $recentPeriodStart = $currentDate->copy()->subDays(30);
        $previousPeriodStart = $recentPeriodStart->copy()->subDays(30);

        return [$recentPeriodStart, $currentDate, $previousPeriodStart];
    }
}
