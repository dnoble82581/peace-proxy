<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class FlashMessageNotification extends Notification
{
    public string $message;

    public string $type;

    public int $userId;

    public function __construct($message, $type, $userId)
    {
        $this->message = $message;
        $this->type = $type;
        $this->userId = $userId;
    }

    public function via($notifiable): array
    {
        return ['broadcast'];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => $this->type,
            'message' => $this->message,
            'user' => $this->userId,
        ]);
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('user.'.$this->userId);
    }

    public function broadcastAs()
    {
        return 'flash-message';
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
