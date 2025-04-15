<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Negotiation extends Model
{
    use BelongsToTenant, HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_training' => 'boolean',
        'weapons_involved' => 'boolean',
    ];

    // Relationships

    public function leadNegotiator()
    {
        return $this->belongsTo(User::class, 'lead_negotiator_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function team()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(NegotiationMessage::class);
    }

    public function demands()
    {
        return $this->hasMany(NegotiationDemand::class);
    }

    public function timelineEvents()
    {
        return $this->hasMany(TimelineEvent::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // Accessors
    public function getIsActiveAttribute()
    {
        return $this->status === 'Active' && is_null($this->end_time);
    }

    public function getFullLocationAttribute()
    {
        return trim("{$this->location}, {$this->city}, {$this->state}", ', ');
    }
}
