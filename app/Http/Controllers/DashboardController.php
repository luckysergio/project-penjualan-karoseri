<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pengiriman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $orderMasuk = Order::where('status_order', 'pending')->count();
        $orderBerjalan = Order::where('status_order', 'proses')->count();
        $orderSelesai = Order::where('status_order', 'selesai')->count();
        $pengirimanAktif = Pengiriman::count();
        $orderSaya = $this->getOrderSaya();
        $orderSelesaiSaya = $this->getOrderSelesaiSaya();
        $pengirimanSaya = $this->getPengirimanSaya();

        return view('pages-admin.dashboard', compact('orderMasuk', 'orderBerjalan','orderSelesai','pengirimanAktif', 'orderSaya','orderSelesaiSaya', 'pengirimanSaya'));
    }

    public function getData()
    {
        $orderMasuk = Order::where('status_order', 'pending')->count();
        $orderBerjalan = Order::where('status_order', 'proses')->count();
        $orderSelesai = Order::where('status_order', 'selesai')->count();
        $pengirimanAktif = Pengiriman::count();
        $orderSaya = $this->getOrderSaya();
        $orderSelesaiSaya = $this->getOrderSelesaiSaya();
        $pengirimanSaya = $this->getPengirimanSaya();

        return response()->json([
            'orderMasuk' => $orderMasuk,
            'orderBerjalan' => $orderBerjalan,
            'orderSelesai' => $orderSelesai,
            'pengirimanAktif' => $pengirimanAktif,
            'orderSaya' => $orderSaya,
            'orderSelesaiSaya' => $orderSelesaiSaya,
            'pengirimanSaya' => $pengirimanSaya,
        ]);
    }

    private function getOrderSaya()
    {
        if (Auth::user()->role_id == 2 && Auth::user()->karyawan) {
            return Order::where('id_sales', Auth::user()->karyawan->id)
                ->whereIn('status_order', ['pending', 'proses'])
                ->count();
        }
        return 0;
    }

    private function getOrderSelesaiSaya()
    {
        if (Auth::user()->role_id == 2 && Auth::user()->karyawan) {
            return Order::where('id_sales', Auth::user()->karyawan->id)
                ->where('status_order', ['selesai'])
                ->count();
        }
        return 0;
    }

    private function getPengirimanSaya()
    {
        if (Auth::user()->role_id == 2 && Auth::user()->karyawan) {
            return Pengiriman::whereHas('order', function ($q) {
                $q->where('id_sales', Auth::user()->karyawan->id);
            })->count();
        }
        return 0;
    }
}
