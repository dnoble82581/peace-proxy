<?php

use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name, 'avatar' => $user->avatarUrl(), 'role' => $user->role];
    }
    abort(403);
});

Broadcast::channel('hook.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});

Broadcast::channel('trigger.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});

Broadcast::channel('demand.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});

Broadcast::channel('chart.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});

Broadcast::channel('associate.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});

Broadcast::channel('objective.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});

Broadcast::channel('subject.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});

Broadcast::channel('warrant.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});

Broadcast::channel('warning.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});

Broadcast::channel('subject-request.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});

Broadcast::channel('response.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});

Broadcast::channel('document.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});

Broadcast::channel('user.{userId}', function ($user, $userId) {
    // Check if the authenticated user is authorized to listen to this channel
    return (int) $user->id === (int) $userId; // Make sure only the user themselves can listen
});

Broadcast::channel('rfi.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});

Broadcast::channel('deliveryPlan.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);
    if ($user->can('view', $room)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    abort(403);
});
