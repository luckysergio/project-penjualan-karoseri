<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Events\OrderNotification;
use App\Events\SalesDashboardUpdated;
use App\Models\Chassis;
use App\Models\JenisDump;
use App\Models\Karyawan;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use App\Models\TypeDump;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function pesanan()
    {
        if (Auth::user()->pelanggan === null) {
            return redirect('/profile')->with('lengkapi_data', true);
        }

        $types = TypeDump::all();
        $jenis = JenisDump::all();
        $chassis = Chassis::all();

        $orders = Order::with([
            'detailOrders.typeDump',
            'detailOrders.jenisDump',
            'detailOrders.chassis',
            'sales.user',
            'pembayarans',
            'pengiriman'
        ])
            ->where('id_pemesan', Auth::user()->pelanggan->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pesanan', compact('types', 'jenis', 'chassis', 'orders'));
    }

    public function index(Request $request)
    {
        $orders = Order::with([
            'pelanggan.user',
            'sales',
            'detailOrders.typeDump',
            'detailOrders.jenisDump',
            'detailOrders.chassis',
            'detailOrders.order.pembayarans',
            'sales.user',
            'pembayarans'
        ])
            ->where('status_order', 'pending')
            ->latest()
            ->paginate(6);

        if ($request->ajax()) {
            return view('pages-admin.order.index', compact('orders'))->render();
        }

        return view('pages-admin.order.index', compact('orders'));
    }

    public function proses(Request $request)
    {
        $orders = Order::with([
            'pelanggan.user',
            'sales',
            'detailOrders.typeDump',
            'detailOrders.jenisDump',
            'detailOrders.chassis',
            'detailOrders.order.pembayarans',
            'sales.user',
            'pembayarans'
        ])
            ->where('status_order', 'proses')  // status proses
            ->latest()
            ->paginate(6);

        if ($request->ajax()) {
            return view('pages-admin.order.proses', compact('orders'))->render();
        }

        return view('pages-admin.order.proses', compact('orders'));
    }

    public function selesai(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $orders = collect();
        $totalOrder = 0;
        $totalPendapatan = 0;
        $rataRata = 0;

        if ($bulan && $tahun) {
            $orders = Order::with(['pengiriman'])
                ->where('status_order', 'selesai')
                ->whereMonth('tanggal_selesai', $bulan)
                ->whereYear('tanggal_selesai', $tahun)
                ->get();

            $totalOrder = $orders->count();

            $totalPendapatan = $orders->sum(function ($order) {
                $biayaPengiriman = $order->pengiriman->biaya ?? 0;
                return $order->total_harga + $biayaPengiriman;
            });

            $rataRata = $totalOrder > 0 ? $totalPendapatan / $totalOrder : 0;
        }

        return view('pages-admin.order.selesai', compact('orders', 'totalOrder', 'totalPendapatan', 'rataRata', 'bulan', 'tahun'));
    }

    public function selesai_sales(Request $request)
    {
        $salesId = Auth::user()->karyawan->id;

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $orders = collect();
        $totalOrder = 0;
        $totalPendapatan = 0;
        $rataRata = 0;

        if ($bulan && $tahun) {
            $orders = Order::with([
                'pelanggan.user',
                'detailOrders.typeDump',
                'detailOrders.jenisDump',
                'detailOrders.chassis',
                'pembayarans',
                'pengiriman'
            ])
                ->where('id_sales', $salesId)
                ->where('status_order', 'selesai')
                ->whereMonth('tanggal_selesai', $bulan)
                ->whereYear('tanggal_selesai', $tahun)
                ->get();

            $totalOrder = $orders->count();

            $totalPendapatan = $orders->sum(function ($order) {
                $biayaPengiriman = $order->pengiriman->biaya ?? 0;
                return $order->total_harga + $biayaPengiriman;
            });

            $rataRata = $totalOrder > 0 ? $totalPendapatan / $totalOrder : 0;
        }

        return view('pages-admin.order.sales-selesai', compact('orders', 'totalOrder', 'totalPendapatan', 'rataRata', 'bulan', 'tahun'));
    }


    public function index_sales(Request $request)
    {
        $salesId = Auth::user()->karyawan->id;

        $orders = Order::with([
            'pelanggan.user',
            'detailOrders.typeDump',
            'detailOrders.jenisDump',
            'detailOrders.chassis',
            'pembayarans',
            'pengiriman'
        ])
            ->where('id_sales', $salesId)
            ->whereIn('status_order', ['pending', 'proses'])
            ->latest()
            ->paginate(6);

        if ($request->ajax()) {
            return view('pages-admin.order-sales.index', compact('orders'))->render();
        }

        return view('pages-admin.order-sales.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'details' => ['required', 'array', 'min:1'],
            'details.*.id_type' => ['required', 'exists:type_dumps,id'],
            'details.*.id_jenis' => ['required', 'exists:jenis_dumps,id'],
            'details.*.id_chassis' => ['required', 'exists:chassis,id'],
            'details.*.qty' => ['required', 'integer', 'min:1'],
            'details.*.harga_order' => ['required', 'numeric'],
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $totalHarga = collect($validated['details'])->sum('harga_order');

                $order = Order::create([
                    'id_pemesan' => Auth::user()->pelanggan->id,
                    'status_order' => 'pending',
                    'total_harga' => $totalHarga,
                ]);

                foreach ($validated['details'] as $detail) {
                    DetailOrder::create([
                        'id_order' => $order->id,
                        'id_type' => $detail['id_type'],
                        'id_jenis' => $detail['id_jenis'],
                        'id_chassis' => $detail['id_chassis'],
                        'qty' => $detail['qty'],
                        'harga_order' => $detail['harga_order'],
                    ]);
                }

                Pembayaran::create([
                    'id_order' => $order->id,
                    'id_pemesan' => Auth::user()->pelanggan->id,
                    'pembayaran' => 0,
                    'bukti' => '',
                ]);
            });

            $this->broadcastDashboardCounts();
            event(new OrderNotification('Ada order baru masuk', 1));

            return back()->with('success', 'Order berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat order: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $order = Order::with('sales')->findOrFail($id);
        $sales = Karyawan::all();

        return view('pages-admin.order.edit', compact('order', 'sales'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_sales' => 'required|exists:karyawans,id',
        ]);

        $order = Order::findOrFail($id);
        $order->id_sales = $validated['id_sales'];
        $order->save();

        $this->broadcastDashboardCounts();

        $karyawan = Karyawan::with('user')->findOrFail($validated['id_sales']);
        $userId = $karyawan->user->id;

        event(new OrderNotification('Sales berhasil di-assign pada order.', 1, $order->id));
        event(new OrderNotification('Ada order baru yang masuk ke Anda.', $userId, $order->id));

        return back()->with('success', 'Sales berhasil ditentukan.');
    }

    public function prosesorder($id)
    {
        $order = Order::with(['detailOrders'])->findOrFail($id);
        return view('pages-admin.order-sales.edit', compact('order'));
    }

    public function updateorder(Request $request, $id)
    {
        $validated = $request->validate([
            'status_order' => 'required|in:pending,proses,selesai,batal',
            'tanggal_selesai' => 'nullable|array',
            'tanggal_selesai.*' => 'nullable|date',
        ]);

        try {
            $order = DB::transaction(function () use ($validated, $id) {
                $order = Order::with('detailOrders')->findOrFail($id);
                $order->status_order = $validated['status_order'];
                $order->save();

                foreach ($order->detailOrders as $detail) {
                    if (isset($validated['tanggal_selesai'][$detail->id])) {
                        $detail->tanggal_selesai = $validated['tanggal_selesai'][$detail->id];
                        $detail->save();
                    }
                }

                $tanggalSelesaiArray = array_filter(array_values($validated['tanggal_selesai']));
                if (!empty($tanggalSelesaiArray)) {
                    $tanggalSelesaiTerakhir = max($tanggalSelesaiArray);
                    $order->tanggal_selesai = $tanggalSelesaiTerakhir;
                } else {
                    $order->tanggal_selesai = null;
                }

                $order->save();

                return $order;
            });

            $this->broadcastDashboardCounts();

            event(new OrderNotification('Status order berhasil diperbarui.', 1, $order->id));

            if ($order->id_sales != 1) {
                event(new OrderNotification('Order Anda telah diproses.', $order->id_sales, $order->id));
            }

            return back()->with('success', 'Order berhasil diproses.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses order: ' . $e->getMessage());
        }
    }

    private function broadcastDashboardCounts()
    {
        try {
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

    public function cetak($id)
    {
        $order = Order::with([
            'pelanggan.user',
            'detailOrders.typeDump',
            'detailOrders.jenisDump',
            'detailOrders.chassis',
            'pengiriman',
            'pembayarans'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('pages-admin.order-sales.pdf', compact('order'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('HOPE-KDT-00' . $order->id . '.pdf');
    }
}
