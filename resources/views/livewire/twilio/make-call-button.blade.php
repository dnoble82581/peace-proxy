<?php

	use App\Models\Subject;
	use Livewire\Volt\Component;
	use Twilio\Rest\Client;


	new class extends Component {
		public Subject $subject;

		public function mount($subjectId)
		{
			$this->subject = $this->getSubject($subjectId);
		}

		public function getSubject($subjectId):Subject
		{
			return Subject::findOrFail($subjectId);
		}

		public function makeCall():void
		{
			// Your Account SID and Auth Token from twilio.com/console
			// To set up environmental variables, see http://twil.io/secure
			$account_sid = config('twilio.account_sid');
			$auth_token = config('twilio.auth_token');
			// In production, these should be environment variables. E.g.:
			// $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

			// A Twilio number you own with Voice capabilities
			$twilio_number = config('twilio.from');

			// Where to make a voice call (your cell phone?)
			$to_number = '+13198537075';

			$client = new Client($account_sid, $auth_token);
			$client->account->calls->create(
				$to_number,
				$twilio_number,
				[
					'twiml' => '<Response><Say>Hi Brielle. This is your dad calling. I am actually very funny!</Say></Response>',
				]
			);
		}
	}
?>

<div>
	<button
			class=""
			wire:click="makeCall">
		<x-heroicons::micro.solid.phone-arrow-up-right class="w-5 h-5 text-emerald-400" />
	</button>
</div>


