<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class DashboardUpdated implements ShouldBroadcastNow
{
    use InteractsWithSockets;

    public $orderMasuk;
    public $orderBerjalan;
    public $orderSelesai;
    public $pengirimanAktif;
    

    public function __construct($orderMasuk, $orderBerjalan, $orderSelesai,$pengirimanAktif)
    {
        $this->orderMasuk = $orderMasuk;
        $this->orderBerjalan = $orderBerjalan;
        $this->orderSelesai = $orderSelesai;
        $this->pengirimanAktif = $pengirimanAktif;
    }

    public function broadcastOn()
    {
        return new Channel('dashboard-channel');
    }
}
