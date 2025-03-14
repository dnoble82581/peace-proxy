<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextMessage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    protected function casts(): array
    {
        return [
            'sent_at' => 'timestamp',
        ];
    }
}
