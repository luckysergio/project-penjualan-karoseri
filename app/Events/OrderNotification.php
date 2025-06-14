<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class OrderNotification implements ShouldBroadcastNow
{
    use InteractsWithSockets;

    public $message;
    public $userId;
    public $orderId;

    public function __construct($message, $userId, $orderId = null)
    {
        $this->message = $message;
        $this->userId = $userId;
        $this->orderId = $orderId;
    }

    public function broadcastOn()
    {
        return new Channel('notification-channel.' . $this->userId);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'order_id' => $this->orderId ? 'HOPE-KDT-00' . str_pad($this->orderId, 4, '0', STR_PAD_LEFT) : null,
            'timestamp' => now()->setTimezone('Asia/Jakarta')->toIso8601String()
        ];
    }
}
