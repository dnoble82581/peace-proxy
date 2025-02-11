<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use DB;
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

    public function addParticipants($userIds): void
    {
        $data = collect($userIds)->map(function ($userId) {
            return [
                'conversation_id' => $this->id,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        // Insert or ignore to avoid duplicate entries
        DB::table('conversation_participants')->insertOrIgnore($data->toArray());
    }
}
