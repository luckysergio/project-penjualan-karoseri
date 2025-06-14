<?php

namespace App\Events;
use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Bus\Dispatchable;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('pelanggan.user', 'sales.user', 'detailOrders.typeDump', 'detailOrders.jenisDump', 'detailOrders.chassis');
    }

    public function broadcastOn()
    {
        return new Channel('orders-channel');
    }
}
