<?php

namespace Modules\Chat\Events;
use Illuminate\Broadcasting\InteractsWithSockets;use Illuminate\Broadcasting\PrivateChannel;use Illuminate\Contracts\Broadcasting\ShouldBroadcast;use Illuminate\Foundation\Events\Dispatchable;use Illuminate\Queue\SerializesModels;
use Modules\Chat\Entities\LiveChat;
use Modules\Chat\Entities\LiveChatMessage;

class LiveChatMessageNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    private int  $user_id;
    public $unseen_count;

    public function __construct($unseen_count,$user_id)
    {
        $this->unseen_count = $unseen_count;
        $this->user_id = $user_id;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('livechat-notification-channel.' . $this->user_id),
        ];
    }

    function broadcastAs(): string
    {
        return 'livechat-notification-' . $this->user_id;
    }
}
