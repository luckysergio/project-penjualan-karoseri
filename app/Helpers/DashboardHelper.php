<?php

namespace App\Helpers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardHelper
{
    public static function getCounts()
    {
        $orderMasuk = Order::where('status_order', 'pending')->count();
        $orderBerjalan = Order::where('status_order','proses')->count();
        $orderSelesai = Order::where('status_order','selesai')->count();

        $orderSaya = 0;
        if (Auth::user()->role_id == 2 && Auth::user()->karyawan) {
            $orderSaya = Order::where('id_sales', Auth::user()->karyawan->id)
                ->whereIn('status_order', ['pending', 'proses'])
                ->count();
        }

        return [
            'orderMasuk' => $orderMasuk,
            'orderSaya' => $orderSaya,
        ];
    }
}
