<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function privateUrl(): string
    {
        if ($this->documentable_type === 'App\Models\User') {
            return url('/documents/user/'.$this->documentable_id.'/'.$this->filename);
        } elseif ($this->documentable_type === 'App\Models\Plan') {
            return url('/documents/plan/'.$this->documentable_id.'/'.$this->filename);
        } elseif ($this->documentable_type === 'App\Models\Negotiation') {
            return url('/documents/negotiation/'.$this->documentable_id.'/'.$this->filename);
        } else {
            return url('/documents/subject/'.$this->documentable_id.'/'.$this->filename);
        }
    }
}
