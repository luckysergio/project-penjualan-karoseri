<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class SalesDashboardUpdated implements ShouldBroadcastNow
{
    use InteractsWithSockets;

    public $orderSaya;
    public $pengirimanSaya;
    public $orderSelesaiSaya;
    public $salesId;


    public function __construct($orderSaya, $pengirimanSaya, $salesId,$orderSelesaiSaya)
    {
        $this->orderSaya = $orderSaya;
        $this->orderSelesaiSaya = $orderSelesaiSaya;
        $this->pengirimanSaya = $pengirimanSaya;
        $this->salesId = $salesId;
    }

    public function broadcastOn()
    {
        return new Channel('sales-dashboard-channel.' . $this->salesId);
    }
}
