<?php

namespace App\Http\Controllers;

use App\Models\JenisDump;
use App\Models\Product;
use App\Models\TypeDump;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Chassis;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SpkWpController extends Controller
{
    public function index()
    {
        $types = TypeDump::with(['detailOrders.order'])->get();

        $data = [];

        foreach ($types as $type) {
            $detailOrders = $type->detailOrders;

            $totalQty = $detailOrders->sum('qty');
            $totalOrder = $detailOrders->count();

            if ($totalOrder == 0) continue;

            $avgQty = $totalQty / $totalOrder;
            $totalHarga = $detailOrders->sum('harga_order');
            $avgHarga = $totalHarga / $totalOrder;

            $totalDurasi = $detailOrders->reduce(function ($carry, $detail) {
                if ($detail->tanggal_selesai && $detail->order && $detail->order->created_at) {
                    $start = Carbon::parse($detail->order->created_at);
                    $end = Carbon::parse($detail->tanggal_selesai);
                    return $carry + $start->diffInDays($end);
                }
                return $carry;
            }, 0);

            $avgDurasi = $totalDurasi / $totalOrder;

            $data[] = [
                'type' => $type->nama,
                'harga' => $avgHarga,
                'avgQty' => $avgQty,
                'avgDurasi' => $avgDurasi,
            ];
        }

        $hasil_spk = $this->hitungWeightedProduct($data);

        $type_dumps = TypeDump::all();
        $jenis_dumps = JenisDump::all();
        $chassis = Chassis::all();
        $products = Product::latest()->take(6)->get();

        return view('home', [
            'hasil' => $hasil_spk,
            'type_dumps' => $type_dumps,
            'jenis_dumps' => $jenis_dumps,
            'chassis' => $chassis,
            'products' => $products
        ]);
    }

    private function hitungWeightedProduct($data)
    {
        if (empty($data)) {
            return [];
        }

        $minHarga = min(array_column($data, 'harga')) ?: 1;
        $maxQty = max(array_column($data, 'avgQty')) ?: 1;
        $minDurasi = min(array_column($data, 'avgDurasi')) ?: 1;

        $bobotHarga = 0.4;
        $bobotQty = 0.3;
        $bobotDurasi = 0.3;

        $totalS = [];
        $temp = [];

        foreach ($data as $item) {
            $nilaiHarga = $minHarga / ($item['harga'] ?: 1);
            $nilaiQty = ($item['avgQty'] ?: 1) / $maxQty;
            $nilaiDurasi = $minDurasi / ($item['avgDurasi'] ?: 1);

            $S = pow($nilaiHarga, $bobotHarga)
               * pow($nilaiQty, $bobotQty)
               * pow($nilaiDurasi, $bobotDurasi);

            $totalS[] = $S;

            $item['S'] = $S;
            $temp[] = $item;
        }

        $sumS = array_sum($totalS);

        if ($sumS == 0) {
            return [];
        }

        foreach ($temp as &$item) {
            $item['V'] = $item['S'] / $sumS;
        }

        usort($temp, function ($a, $b) {
            return $b['V'] <=> $a['V'];
        });

        return $temp;
    }
}
