<?php

use App\Events\ChartUpdatedEvent;
use App\Models\Room;
use Carbon\Carbon;
use Livewire\Volt\Component;

// Define an anonymous Livewire component
new class extends Component {
    public Room $room; // Associated Room model instance
    public array $moodLabels = []; // Chart labels (timestamps)
    public array $moodData = []; // Chart data (mood values)

    // Mount method is called when the component is initialized
    public function mount($room):void
    {
        // Assign the passed-in Room to the component
        $this->room = $room;

        // Prepare initial chart data
        $this->prepareChart();
    }

    /**
     * Logs a mood, saves it in the database, and updates the chart on the frontend.
     *
     * @param  int  $mood  - Mood value (e.g., -4 to 4)
     * @param  string  $name  - Mood's descriptive name
     */
    public function logMood($mood, $name):void
    {
        // Create a new mood log entry in the database
        $newMood = $this->room->subject->moodLogs()->create([
            'time' => now(), // Current timestamp for the mood log
            'mood' => $mood, // Mood value
            'name' => $name, // Descriptive name of the mood
            'subject_id' => $this->room->subject->id, // Associated subject ID
            'negotiation_id' => $this->room->negotiation->id, // Negotiation ID
            'room_id' => $this->room->id, // Room ID
            'tenant_id' => $this->room->tenant_id // Tenant ID
        ]);

//        broadcast(new ChartUpdatedEvent($newMood->id, $this->room->id));

        // Dispatches an event to refresh the related subject
        $this->dispatch('refreshSubject');
        event(new ChartUpdatedEvent($this->room->id, $newMood->id));

        // Format the timestamp for updating the chart
        $newLabel = $newMood->created_at->format('D:H:i');

        // Dispatch a 'moodUpdate' event to the frontend with the new label and mood value
        $this->dispatch('moodUpdate', $newLabel, $newMood->mood);
    }

    /**
     * Prepares the data for the mood chart by fetching the latest mood logs.
     */
    public function prepareChart():void
    {
        // Fetch up to 6 of the most recent mood logs, sorted by time descending
        foreach ($this->room->subject->moodLogs->sortByDesc('created_at')->take(6) as $mood) {
            // Format the creation timestamp for the x-axis labels
            $this->moodLabels[] = Carbon::parse($mood->created_at)
                ->setTimezone(config(key: 'app.timezone')) // Adjust to the app's timezone
                ->format('D:H:i'); // Format as Day:Hour:Minute

            // Add the mood value to the data array
            $this->moodData[] = $mood->mood;
        }

        // Log a message if either the labels or data arrays are empty
        if (empty($this->moodLabels) || empty($this->moodData)) {
            logger('Chart data is empty. Check moodLogs data structure.');
        }
    }


}

?>

		<!-- Frontend Markup -->
<div
		wire:ignore
		class="bg-white dark:bg-gray-800">
	<!-- Canvas for the Chart.js chart -->
	<canvas id="moodChart"></canvas>

	<!-- Mood buttons for logging mood -->
	<div class="mt-2 flex space-x-2 justify-between items-center dark:opacity-80 dark:bg-gray-800 mb-4 rounded p-2">
		<!-- Button for "Saddest" mood -->
		<button
				wire:click="logMood(-4, 'Saddest')"
				class="w-8 h-8 hover:-translate-y-[3px] hover:scale-110 transition-transform duration-300 ease-in-out dark:bg-gray-800">
			<x-svg-images.mood_emojis.saddest />
		</button>
		<!-- Button for "Sad" mood -->
		<button
				wire:click="logMood(-3, 'Sad')"
				class="w-8 h-8 hover:-translate-y-[3px] hover:scale-110 transition-transform duration-300 ease-in-out">
			<x-svg-images.mood_emojis.depressed />
		</button>
		<!-- Button for "Down" mood -->
		<button
				wire:click="logMood(-2, 'Down')"
				class="w-8 h-8 hover:-translate-y-[3px] hover:scale-110 transition-transform duration-300 ease-in-out">
			<x-svg-images.mood_emojis.sad />
		</button>
		<!-- Button for "Anxious" mood -->
		<button
				wire:click="logMood(-1, 'Anxious')"
				class="w-8 h-8 hover:-translate-y-[3px] hover:scale-110 transition-transform duration-300 ease-in-out">
			<x-svg-images.mood_emojis.anxious />
		</button>
		<!-- Button for "Base" mood -->
		<button
				wire:click="logMood(0, 'Base')"
				class="w-8 h-8 hover:-translate-y-[3px] hover:scale-110 transition-transform duration-300 ease-in-out">
			<x-svg-images.mood_emojis.base_line />
		</button>
		<!-- Button for "Happy" mood -->
		<button
				wire:click="logMood(1, 'Happy')"
				class="w-8 h-8 hover:-translate-y-[3px] hover:scale-110 transition-transform duration-300 ease-in-out">
			<x-svg-images.mood_emojis.happy />
		</button>
		<!-- Button for "Nervous" mood -->
		<button
				wire:click="logMood(2, 'Nervous')"
				class="w-8 h-8 hover:-translate-y-[3px] hover:scale-110 transition-transform duration-300 ease-in-out">
			<x-svg-images.mood_emojis.annoyed />
		</button>
		<!-- Button for "Upset" mood -->
		<button
				wire:click="logMood(3, 'Upset')"
				class="w-8 h-8 hover:-translate-y-[3px] hover:scale-110 transition-transform duration-300 ease-in-out">
			<x-svg-images.mood_emojis.upset />
		</button>
		<!-- Button for "Mad" mood -->
		<button
				wire:click="logMood(4, 'Mad')"
				class="w-8 h-8 hover:-translate-y-[3px] hover:scale-110 transition-transform duration-300 ease-in-out">
			<x-svg-images.mood_emojis.mad />
		</button>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('moodChart')
  if (ctx) {
    // Initializes a new Chart.js line chart
    let moodChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: @json($moodLabels), // X-axis labels (timestamps)
        datasets: [{
          label: 'Mood Point', // Dataset label
          data: @json($moodData), // Y-axis data (mood scores)
          borderWidth: 1,
          borderColor: 'rgba(45, 212, 191, 1)', // Line color (Blue in this example)
          backgroundColor: 'rgba(54, 162, 235, 0.2)', // Optional: Fill color under the line (transparent blue)
        }]
      },
      options: {
        responsive: true, // Adjust chart size to container
        plugins: {
          title: {
            display: true,
            text: 'Mood Log Tracker' // Chart title
          }
        },
        scales: {
          y: {
            beginAtZero: true, // Start y-axis at 0
          }
        }
      }
    })

    // Listen for mood update events
    window.addEventListener('moodUpdate', event => {
      const { detail: [newLabel, newData] } = event

      addMood(moodChart, newLabel, newData) // Add updated mood to the chart
    })

    /**
     * Updates the chart with a new data point.
     *
     * @param {Object} chart - The Chart.js instance
     * @param {string} newLabel - New label for the x-axis
     * @param {number} newData - New data point for the y-axis
     */
    function addMood (chart, newLabel, newData) {
      if (newLabel == null || newData == null) { // Validate data
        console.error('Invalid mood update data:', { label: newLabel, data: newData })
        return
      }

      // Add new data point and label to the beginning of the chart
      chart.data.labels.unshift(newLabel)
      chart.data.datasets.forEach((dataset) => {
        dataset.data.unshift(newData)
      })

      // Limit chart to 5 data points
      if (chart.data.labels.length > 5) {
        chart.data.labels.pop() // Remove the oldest label
        chart.data.datasets.forEach((dataset) => {
          dataset.data.pop() // Remove the oldest data point
        })
      }

      chart.update() // Redraw the chart
    }
  }
</script>