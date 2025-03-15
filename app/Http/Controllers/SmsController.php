<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Services\MessageService;
use App\Services\PhoneNumberService;
use App\Services\VonageSmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsController extends Controller
{
    protected VonageSmsService $vonageSMSService;

    public function __construct(VonageSMSService $vonageSMSService)
    {
        $this->vonageSMSService = $vonageSMSService;
    }

    public function receiveSms(Request $request, PhoneNumberService $phoneNumberService)
    {
        // Log the incoming message for debugging
        Log::info('Inbound SMS received:', $request->all());

        // Extract key data from Vonage's payload
        $from = $phoneNumberService->formatToE164($request->msisdn);
        $to = $phoneNumberService->formatToE164($request->to); // Receiving phone number
        $messageContent = $request->text; // The message content
        $time_stamp = $request->input('message-timestamp');
        $messageId = $request->messageId;

        // Find the Subject associated with the sender's phone number
        $subject = Subject::where('phone', $phoneNumberService->formatToE164($from))->first();

        if (! $subject) {
            Log::warning("No subject found for phone number: $from");

            return response()->json(['status' => 'error', 'message' => 'Sender not recognized.'], 400);
        }

        // Assign room_id and conversation_id
        $roomId = $subject->room_id; // Retrieve room_id if related properly
        $conversation = $subject->conversations()->where('name',
            $phoneNumberService->formatToE164($subject->phone))->first();
        $conversationId = $conversation ? $conversation->id : null;

        $messageService = new MessageService;
        $newMessage = $messageService->createMessage($subject->room, $subject, $messageContent, $conversationId);
        $newMessage->update([
            'recipient' => $to,
            'message_status' => 'delivered',
            'message_type' => 'text',
            'message_id' => $messageId,
        ]);

        Log::info('room_id: '.$roomId.' conversation_id: '.$conversationId);
        // Create the TextMessage record

        // Log the successful save
        Log::info("Message received from $from and saved to database.");

        // Return a 200 response to Vonage
        return response()->json(['status' => 'received'], 200);
    }

    protected function replyToSender($to, $message)
    {
        Log::info("Replying to $to with $message");

    }
}
