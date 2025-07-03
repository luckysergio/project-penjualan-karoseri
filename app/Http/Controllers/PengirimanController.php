<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Events\SalesDashboardUpdated;
use App\Models\Order;
use App\Models\Pengiriman;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PengirimanController extends Controller
{
    public function indexAdmin()
    {
        $pengirimans = Pengiriman::with('order', 'sales.user')
            ->where('status', ['persiapan', 'dikirim', 'selesai'])
            ->latest()
            ->paginate(6);

        return view('pages-admin.pengiriman.indexadmin', compact('pengirimans'));
    }

    public function indexSales()
    {
        $salesId = Auth::user()->karyawan->id;

        $pengirimans = Pengiriman::whereHas('order', function ($q) use ($salesId) {
            $q->where('id_sales', $salesId);
        })
            ->whereIn('status', ['persiapan', 'dikirim', 'selesai'])
            ->with('order')
            ->orderByRaw("FIELD(status, 'persiapan', 'dikirim', 'selesai')")
            ->paginate(6);

        return view('pages-admin.pengiriman.indexsales', compact('pengirimans'));
    }

    public function create()
    {
        $this->authorizeSales();

        $salesId = Auth::user()->karyawan->id;
        $orders = Order::where('id_sales', $salesId)->doesntHave('pengiriman')->get();

        return view('pages-admin.pengiriman.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $this->authorizeSales();

        $validated = $request->validate([
            'id_order' => 'required|exists:orders,id',
            'alamat' => 'required|string|max:250',
            'biaya' => 'required',
            'tanggal_kirim' => 'nullable|date',
            'tanggal_sampai' => 'nullable|date|after_or_equal:tanggal_kirim',
            'status' => 'required|in:persiapan,dikirim,selesai',
        ]);

        $order = Order::findOrFail($validated['id_order']);

        if ($order->id_sales != Auth::user()->karyawan->id) {
            abort(403, 'Order ini bukan milik Anda.');
        }

        $validated['biaya'] = $this->sanitizeRupiah($validated['biaya']);

        Pengiriman::create($validated);

        $this->broadcastDashboardCounts();

        return back()->with('success', 'Pengiriman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengiriman = Pengiriman::with('order')->findOrFail($id);

        if (Auth::user()->role_id == 1) {
            return view('pages-admin.pengiriman.edit-admin', compact('pengiriman'));
        }

        $salesId = Auth::user()->karyawan->id;

        if ($pengiriman->order->id_sales != $salesId) {
            abort(403, 'Pengiriman ini bukan milik Anda.');
        }

        return view('pages-admin.pengiriman.edit', compact('pengiriman'));
    }

    public function update(Request $request, $id)
    {
        $pengiriman = Pengiriman::with('order')->findOrFail($id);

        if (Auth::user()->role_id == 1) {
            abort(403, 'Admin tidak dapat mengubah pengiriman.');
        }

        $salesId = Auth::user()->karyawan->id;

        if ($pengiriman->order->id_sales != $salesId) {
            abort(403, 'Pengiriman ini bukan milik Anda.');
        }

        $validated = $request->validate([
            'alamat' => 'required|string|max:250',
            'biaya' => 'required',
            'tanggal_kirim' => 'nullable|date',
            'tanggal_sampai' => 'nullable|date|after_or_equal:tanggal_kirim',
            'status' => 'required|in:persiapan,dikirim,selesai',
        ]);

        $validated['biaya'] = $this->sanitizeRupiah($validated['biaya']);

        $pengiriman->update($validated);

        $this->broadcastDashboardCounts();

        return back()->with('success', 'Pengiriman berhasil diperbarui.');
    }

    private function sanitizeRupiah($value)
    {
        return (int) preg_replace('/[^\d]/', '', $value);
    }

    private function authorizeSales()
    {
        if (Auth::user()->role_id != 2) {
            abort(403, 'Hanya sales yang dapat mengakses.');
        }
    }

    private function broadcastDashboardCounts()
    {
        try {
            // Untuk Admin
            $orderMasuk = Order::where('status_order', 'pending')->count();
            $orderBerjalan = Order::where('status_order', 'proses')->count();
            $orderSelesai = Order::where('status_order', 'selesai')->count();
            $pengirimanAktif = Pengiriman::count();
            event(new DashboardUpdated($orderMasuk, $orderBerjalan, $orderSelesai, $pengirimanAktif));

            $sales = Karyawan::all();

            foreach ($sales as $karyawan) {
                $orderSaya = Order::where('id_sales', $karyawan->id)
                    ->whereIn('status_order', ['pending', 'proses'])
                    ->count();

                $pengirimanSaya = Pengiriman::whereHas('order', function ($q) use ($karyawan) {
                    $q->where('id_sales', $karyawan->id);
                })->count();

                $orderSelesaiSaya = Order::where('id_sales', $karyawan->id)
                    ->where('status_order', 'selesai')
                    ->count();

                event(new SalesDashboardUpdated(
                    $orderSaya,
                    $pengirimanSaya,
                    $orderSelesaiSaya,
                    $karyawan->id
                ));
            }
        } catch (\Exception $e) {
            Log::error("Gagal broadcast pusher: " . $e->getMessage());
        }
    }
}
