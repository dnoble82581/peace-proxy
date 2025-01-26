<?php

namespace App\Traits;

use App\Models\Room;

trait Searchable
{
    public string $search = '';

    public Room $room;

    public function applySearch(
        $query,
        array $columns
    ) {
        if (! empty($this->search)) {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%'.$this->search.'%');
                }
            });
        }

        return $query->get();

    }
}
