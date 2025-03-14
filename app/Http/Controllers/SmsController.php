<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\TextMessage;
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

    public function sendSms(Request $request)
    {
        $recipient = Subject::find(10); // Ensure this is valid
        $messageContent = 'Some great message';

        $this->vonageSMSService->sendMessage($recipient, $messageContent);

        return redirect()->back()->with('message', 'SMS sent successfully!');
    }

    public function receiveSms(Request $request, PhoneNumberService $phoneNumberService)
    {
        // Log the incoming message for debugging
        Log::info('Inbound SMS received:', $request->all());

        // Extract key data from Vonage's payload
        $from = $phoneNumberService->formatToE164($request->msisdn);
        $to = $phoneNumberService->formatToE164($request->to); // Sender's phone number
        $messageContent = $request->text; // The message content
        $time_stamp = $request->input('message-timestamp');
        $messageId = $request->messageId;
        $subject = Subject::where('phone', $from)->first();

        // Unique ID for the message
        TextMessage::create([
            'sender' => $from,
            'sender_id' => 10,
            'recipient_id' => 1,
            'recipient' => $to,
            'message_content' => $messageContent,
            'message_status' => 'received',
            'message_type' => 'received',
            'message_id' => $messageId,
            'sent_at' => $time_stamp,
        ]);

        // Log the incoming message into the database

        // Return a 200 response to Vonage
        return response()->json(['status' => 'received'], 200);
    }

    protected function replyToSender($to, $message)
    {
        Log::info("Replying to $to with $message");
        //        $user = new User; // Temporary user object
        //        $user->phone_number = $to;
        //        $user->notify(new GenericReply($message));
    }
}
