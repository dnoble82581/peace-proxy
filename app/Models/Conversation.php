<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use BelongsToTenant;

    protected $guarded = ['id'];

    public function unreadMessagesCount(): int
    {
        return $this->messages()->where('is_read', false)
            ->where('senderable_id', '!=', Auth::id())
            ->count();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    // Relationship to SMS Messages
    public function textMessages(): HasMany
    {
        return $this->hasMany(TextMessage::class, 'conversation_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
            ->withPivot('joined_at', 'status')
            ->withTimestamps();
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function scopePrivate($query)
    {
        return $query->where('type', 'private');
    }

    public function scopePublic($query)
    {
        return $query->where('type', 'public');
    }

    public function getOtherParticipantCount(): int
    {
        $authUserId = Auth::id();

        // Get users linked to conversation participants, excluding the authenticated user
        return $this->participants
            ->where('user_id', '!=', $authUserId) // Exclude the authenticated user at the query level
            ->count(); // Count the remaining participants
    }
}
