<?php

namespace Tests\Feature;

use App\Http\Livewire\ChatRoom;
use App\Models\Room;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class ChatRoomTest extends TestCase
{
    /** @test */
    public function it_validates_message_sending()
    {
        $room = Room::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test(ChatRoom::class, ['room' => $room])
            ->set('newMessage', '')
            ->call('sendMessage')
            ->assertHasErrors(['newMessage' => 'required']);
    }

    /** @test */
    public function it_sends_message_succesfully()
    {
        $room = Room::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test(ChatRoom::class, ['room' => $room])
            ->set('newMessage', 'Test message')
            ->call('sendMessage');

        $this->assertDatabaseHas('messages', [
            'message' => 'Test message',
            'room_id' => $room->id,
            'user_id' => $user->id,
        ]);
    }
}
