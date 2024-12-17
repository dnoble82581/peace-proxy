<?php

use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public int $milliseconds = 0;
    public int $seconds = 0;
    public int $minutes = 0;
    public int $hours = 0;

    #[On('save-time')]
    public function save():void
    {
        $hours = $this->hours;
        $minutes = $this->minutes;
        $seconds = $this->seconds;
        $durationInSeconds = $hours + $minutes + $seconds;
        $this->dispatch('time-to-save', $durationInSeconds);
    }
}

?>

<div
		x-data="{
		showTimer: false,
		milliseconds: @entangle('milliseconds'),
		seconds: @entangle('seconds'),
		minutes: @entangle('minutes'),
		hours: @entangle('hours'),
		appendHours: document.querySelector('#hours'),
		appendMinutes: document.querySelector('#minutes'),
		appendSeconds: document.querySelector('#seconds'),
		appendMilliseconds: document.querySelector('#milliseconds')
		}"
		x-show="showTimer"
		x-init="
			window.addEventListener('show-timer', () => {
				showTimer = true
			})
			window.addEventListener('hide-timer', () => {
				showTimer = false
			})

			window.onload = function () {
			    let interval

			    const startTimer = () => {
			      interval = setInterval(() => {
			        milliseconds++
			        if (milliseconds < 10) {
			          appendMilliseconds.innerHTML = '00' + milliseconds
			        } else if (milliseconds < 100) {
			          appendMilliseconds.innerHTML = '0' + milliseconds
			        } else {
			          appendMilliseconds.innerHTML = milliseconds
			        }

			        if (milliseconds > 999) {
			          seconds++
			          appendSeconds.innerHTML = seconds < 10 ? '0' + seconds : seconds
			          milliseconds = 0
			          appendMilliseconds.innerHTML = '000'
			        }

			        if (seconds > 59) {
			          minutes++
			          appendMinutes.innerHTML = minutes < 10 ? '0' + minutes : minutes
			          seconds = 0
			          appendSeconds.innerHTML = '00'
			        }
			        if (minutes > 59) {
			        hours++
			        appendHours.innerHTML = hours < 10 ? '0' + hours : hours
			        minutes = 0
			        appendMinutes.innerHTML = '00'
			        }
			      }, 1)
			    }

			    const stopTimer = () => clearInterval(interval)

			    const resetTimer = () => {
			      clearInterval(interval)
			      console.log('made it');
			      minutes = 0
			      seconds = 0
			      milliseconds = 0
			      appendMinutes.innerHTML = '00'
			      appendSeconds.innerHTML = '00'
			      appendMilliseconds.innerHTML = '000'
			    }
			    window.addEventListener('show-timer', startTimer)
			    window.addEventListener('stop-timer', stopTimer)
			    window.addEventListener('reset-timer', resetTimer)
			    window.addEventListener('test-time', $wire.save)
			  }
		"
		x-transition:enter="ease-out duration-300"
		x-transition:enter-start="opacity-0"
		x-transition:enter-end="opacity-100"
		x-transition:leave="ease-in duration-200"
		x-transition:leave-start="opacity-100"
		x-transition:leave-end="opacity-0"
>
	<p class="text-xs text-slate-600 dark:text-slate-400">
		<span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span>:<span id="milliseconds">000</span>
	</p>
</div>
