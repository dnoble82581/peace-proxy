@php use Illuminate\Support\Carbon; @endphp
		<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Negotiation Logs</title>
	<style>
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            line-height: 1.5;
            color: #333;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
        }

        ol {
            list-style: none;
            padding-left: 0;
            border-left: 2px solid #ddd;
        }

        ol li {
            position: relative;
            margin-bottom: 20px;
            padding-left: 20px;
        }

        ol li::before {
            content: "";
            position: absolute;
            top: 8px;
            left: -7px;
            width: 14px;
            height: 14px;
            background: #ddd;
            border-radius: 50%;
            border: 2px solid white;
        }

        .time {
            font-size: 12px;
            color: #888;
        }

        .action {
            font-weight: bold;
            font-size: 16px;
            margin: 5px 0;
        }

        .description {
            font-size: 14px;
            color: #555;
        }

        .line-through {
            text-decoration: line-through;
            color: #999;
        }
	</style>
</head>
<body>
<div class="container">
	<h1>Negotiation Log</h1>
	<p>{{ $negotiation->address }}</p>
	<p>{{ $negotiation->city }} {{ $negotiation->state }} {{ $negotiation->zip }}</p>
	<p>{{ $negotiation->resolution }}</p>
	<ol>
		@foreach($negotiation->logs as $log)
			<li>
				<time class="time">
					{{ Carbon::parse($log->created_at)->format('d-m-Y H:i') }}
				</time>
				<div class="action">
					{{ $log->action }} —
					<span>{{ $log->user->name ?? 'Unknown User' }}</span>
				</div>
				@php
					$logStyle = match($log->action) {
						'Hook Created', 'Trigger Created' => '',
						'Hook Deleted', 'Trigger Deleted' => 'line-through',
						default => '',
					};
				@endphp
				@if(isset($log->data['description']))
					<p class="description {{ $logStyle }}">
						{{ $log->data['title'] }} :
						{{ $log->data['description'] }}
					</p>
				@endif
			</li>
		@endforeach
	</ol>
</div>
</body>
</html>