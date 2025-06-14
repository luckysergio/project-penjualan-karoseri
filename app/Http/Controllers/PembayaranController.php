<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index(Order $order)
    {
        $order->load('pengiriman', 'pembayarans');
        return view('pembayaran', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        // Bersihkan input sebelum validasi
        $pembayaranInput = str_replace('.', '', $request->pembayaran);
        $pembayaran = (int) $pembayaranInput;
        $request->merge(['pembayaran' => $pembayaran]);

        $request->validate([
            'pembayaran' => 'required|numeric|min:1000',
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Ambil total produk
        $totalProduk = $order->total_harga ?? 0;

        // Ambil biaya pengiriman dari relasi pengiriman
        $biayaPengiriman = optional($order->pengiriman)->biaya ?? 0;

        // Hitung total tagihan
        $totalTagihan = $totalProduk + $biayaPengiriman;

        // Hitung sisa
        $totalBayar = $order->pembayarans->sum('pembayaran');
        $sisa = $totalTagihan - $totalBayar;

        if ($pembayaran > $sisa) {
            return redirect()->back()->with('error', 'Jumlah pembayaran melebihi sisa tagihan.');
        }

        $path = $request->file('bukti')->store('bukti_pembayaran', 'public');

        Pembayaran::create([
            'id_order' => $order->id,
            'id_pemesan' => $order->id_pemesan,
            'pembayaran' => $pembayaran,
            'bukti' => $path,
        ]);

        return redirect()->route('pembayaran.index', $order->id)->with('success', 'Pembayaran berhasil diupload.');
    }
}
