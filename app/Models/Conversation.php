<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use BelongsToTenant;

    protected $guarded = ['id'];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    public function initiator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    public function scopePrivate($query)
    {
        return $query->where('type', 'private');
    }

    public function scopePublic($query)
    {
        return $query->where('type', 'public');
    }

    public function getOtherParticipantName(): string
    {
        $authUserId = auth()->id();

        // Ensure participants are loaded and eager-load associated User models
        $this->loadMissing('participants.user');

        // Safely retrieve the first participant who is not the auth user
        $otherParticipant = $this->participants
            ->firstWhere('user_id', '!=', $authUserId);

        return $otherParticipant && $otherParticipant->user
            ? $otherParticipant->user->name
            : 'Unknown';
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }
}
