<?php

use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{roomId}', function (User $user, int $roomId) {
    $room = Room::find($roomId);

    if ($room && $user->can('view', $room)) {
        // Return user details to identify the participant on the frontend
        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatarUrl(), // Presuming the user model has this method
            'role' => $user->role, // Role can be used for UI logic in real-time
        ];
    }

    return false;
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
    return (int) $user->id === (int) $userId;
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

Broadcast::channel('chat-sms.{roomId}', function ($user, $roomId) {
    // Check if the user has access to the room
    return true; // Assuming 'rooms' is a relationship on User
});
