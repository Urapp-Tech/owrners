<?php

namespace App\Events;

use App\Models\ClientNotification;
use App\Models\FreelancerNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int  $user_id;
    public $notification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FreelancerNotification | ClientNotification $_notification)
    {
        $this->notification = $_notification;
        if ($this->notification instanceof ClientNotification) {
            $this->user_id = $this->notification->client_id;
        }
        else if ($this->notification instanceof FreelancerNotification) {
            $this->user_id = $this->notification->freelancer_id;
        }

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('app-notification-channel.'. $this->user_id);

    }

    function broadcastAs(): string
    {
        return 'app-notification-' . $this->user_id;
    }
}
