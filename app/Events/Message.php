<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Message implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    public $id;
    public $file;
    public $time;
    public $message_id;
    public $replied_to_user;
    public $replied_to_message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $message, $id, $file = '', $time, $message_id, $replied_to_user = '', $replied_to_message = '')
    {
        $this->user = $user;
        $this->message = $message;
        $this->id = $id;
        $this->file = $file;
        $this->time = $time;
        $this->message_id = $message_id;
        $this->replied_to_user = $replied_to_user;
        $this->replied_to_message = $replied_to_message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat');
    }

    public function broadcastAs()
    {
        return 'message';
    }
}
