<?php

namespace App\Services;

use App\Models\TextMessage;
use Exception;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class VonageSmsService
{
    protected Client $client;

    public function __construct()
    {
        $basic = new Basic(config('vonage.api_key'), config('vonage.api_secret'));
        $this->client = new Client($basic);
    }

    public function sendMessage($recipient, $messageContent, $conversationId = null)
    {
        $from = config('vonage.api_from');

        try {
            $response = $this->client->sms()->send(
                new SMS($recipient->routeNotificationForVonage(), $from, $messageContent)
            );

            $message = $response->current();

            // Log the message details into the database
            return TextMessage::create([
                'sender' => $from,
                'recipient' => $recipient->routeNotificationForVonage(),
                'sender_id' => auth()->user()->id,
                'conversation_id' => $conversationId,
                'room_id' => $recipient->room_id,
                'recipient_id' => $recipient->id,
                'message_content' => $messageContent,
                'message_status' => $message->getStatus() === 0 ? 'delivered' : 'failed',
                'message_type' => 'sent',
                'message_id' => $message->getMessageId(),
                'sent_at' => now(),
            ]);

        } catch (Exception $e) {
            // Log the failure in case of an exception
            return TextMessage::create([
                'sender' => $from,
                'recipient' => $recipient->routeNotificationForVonage(),
                'sender_id' => auth()->user()->id,
                'recipient_id' => $recipient->id,
                'message_content' => $messageContent,
                'message_status' => 'failed',
                'message_type' => 'sent',
                'sent_at' => now(),
            ]);
        }
    }
}
