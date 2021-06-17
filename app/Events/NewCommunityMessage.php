<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\CommunityMessage;

class NewCommunityMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $communityMessage;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CommunityMessage $communityMessage)
    {
        $this->communityMessage = $communityMessage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('community.' . $this->communityMessage->community_id);
    }

    public function broadcastAs()
    {
        return 'community.new';
    }
}
