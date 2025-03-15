<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Subject;
use Exception;
use Log;
use Throwable;
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

    /**
     * @throws Exception
     */
    public function sendMessage(Message $message, Subject $subject): void
    {
        $from = config('vonage.api_from');
        $recipient = $subject;

        try {
            $response = $this->client->sms()->send(
                new SMS($recipient->routeNotificationForVonage(), $from, $message->message)
            );

            // Update message status after successful send
            $message->update([
                'message_status' => 'sent',
                'message_type' => 'text',
            ]);

        } catch (Throwable $e) {
            // Log the exception for debugging purposes
            Log::error('Failed to send SMS', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'recipient' => $recipient->routeNotificationForVonage(),
                'message_content' => $message->message,
            ]);

            // Update the message status to failed
            $message->update([
                'message_status' => 'failed',
                'message_type' => 'text',
            ]);

            // Optionally, you could rethrow or handle specific exceptions further
            throw new Exception('Message sending failed: '.$e->getMessage(), 0, $e);
        }

    }
}
