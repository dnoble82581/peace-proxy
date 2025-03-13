<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class RecordRetrievalService
{
    /**
     * Retrieve records created within a given time frame.
     *
     * @param  Model|Builder  $query  A model instance or an Eloquent query builder.
     * @param  int  $days  The number of days to look back.
     * @return Builder The query with the filter applied.
     */
    public function getRecordsWithinTimeFrame(Model|Builder $query, int $days): Builder
    {
        // Calculate the start date for the time frame
        $startDate = Carbon::now()->subDays($days);

        // Apply a where clause to filter records created after the start date
        return $query->where('created_at', '>=', $startDate);
    }
}
