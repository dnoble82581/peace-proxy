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
        return ['id' => $user->id, 'name' => $user->name];
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
