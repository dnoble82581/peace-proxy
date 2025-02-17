<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class SocialMediaProvider extends Model
{
    protected $guarded = ['id'];

    public function providerables(): MorphToMany
    {
        return $this->morphToMany('App\Models\Subject', 'providerable');
    }
}
