@extends('layouts.app')

@section('title', 'Pembayaran')

@section('contentweb')

    {{-- AOS & SweetAlert --}}
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.all.min.js"></script>

    {{-- Flash Message --}}
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}'
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}'
            });
        @endif
    </script>

    {{-- Header --}}
    <section class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white py-16 sm:py-20"
        data-aos="fade-down" data-aos-duration="1000">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4">Pembayaran</h1>
            <p class="text-lg sm:text-xl opacity-90 max-w-2xl mx-auto">Silahkan lakukan pembayaran</p>
        </div>
    </section>

    {{-- Isi Pembayaran --}}
    <section class="py-12 bg-slate-50">
        <div class="max-w-5xl mx-auto px-4">

            {{-- Informasi Order --}}
            <div class="bg-white p-6 rounded-xl shadow mb-6" data-aos="fade-up" data-aos-delay="100">
                <h2 class="text-xl font-semibold mb-4">Detail Pesanan</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700">
                    <div>No. Order: <span class="font-bold">HOPE-KDT-00{{ $order->id }}</span></div>
                    <div>Status Order: <span class="font-bold capitalize">{{ $order->status_order }}</span></div>
                    <div>Tanggal Order: <span
                            class="font-bold">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</span></div>
                </div>

                {{-- Detail Item --}}
                <div class="mt-6">
                    <h3 class="font-semibold mb-2">Detail Produk:</h3>
                    <div class="space-y-2">
                        @foreach ($order->detailOrders as $item)
                            <div class="flex justify-between bg-slate-100 p-3 rounded-lg" data-aos="fade-right"
                                data-aos-delay="200">
                                <div>
                                    <span class="font-bold">{{ $item->typeDump->nama }} / {{ $item->jenisDump->nama }} /
                                        {{ $item->chassis->nama }}</span>
                                    <span class="text-sm text-slate-500">Qty: {{ $item->qty }} unit</span>
                                </div>
                                <div class="font-bold text-indigo-600">
                                    Rp {{ number_format($item->harga_order, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Total Pembayaran --}}
            @php
                $totalProduk = $order->total_harga ?? 0;
                $biayaPengiriman = optional($order->pengiriman)->biaya ?? 0;
                $totalTagihan = $totalProduk + $biayaPengiriman;
                $totalBayar = $order->pembayarans->sum('pembayaran');
                $sisa = $totalTagihan - $totalBayar;
            @endphp

            <div class="bg-white p-6 rounded-xl shadow mb-6" data-aos="fade-up" data-aos-delay="200">
                <h2 class="text-xl font-semibold mb-4">Rekap Pembayaran</h2>

                <div class="space-y-2 text-slate-700">
                    <div>Total Produk: <span class="font-bold">Rp {{ number_format($totalProduk, 0, ',', '.') }}</span>
                    </div>
                    <div>Biaya Pengiriman: <span class="font-bold">Rp
                            {{ number_format($biayaPengiriman, 0, ',', '.') }}</span></div>
                    <div>Total Tagihan: <span class="font-bold text-indigo-600">Rp
                            {{ number_format($totalTagihan, 0, ',', '.') }}</span></div>
                    <div>Total Dibayar: <span class="font-bold text-green-600">Rp
                            {{ number_format($totalBayar, 0, ',', '.') }}</span></div>
                    <div>Sisa Pembayaran: <span class="font-bold text-red-600">Rp
                            {{ number_format($sisa, 0, ',', '.') }}</span></div>
                </div>
            </div>

            {{-- Form Pembayaran --}}
            <div class="bg-white p-6 rounded-xl shadow mb-6" data-aos="zoom-in-up" data-aos-delay="300">
                <h2 class="text-xl font-semibold mb-4">Lakukan Pembayaran</h2>

                <form action="{{ route('pembayaran.store', $order->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4" id="formPembayaran">
                    @csrf

                    {{-- Input Pembayaran --}}
                    <div data-aos="fade-up" data-aos-delay="400">
                        <label for="pembayaran" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pembayaran
                            (Rp)</label>
                        <input type="text" name="pembayaran" id="pembayaran" inputmode="numeric"
                            class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                            {{ $errors->has('pembayaran') ? 'border-red-500' : 'border-gray-300' }}"
                            value="{{ old('pembayaran') }}" placeholder="Masukkan nominal pembayaran">
                        @error('pembayaran')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload Bukti --}}
                    <div data-aos="fade-up" data-aos-delay="500">
                        <label for="bukti" class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti
                            Pembayaran</label>
                        <input type="file" name="bukti" id="bukti" accept="image/*"
                            class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                            {{ $errors->has('bukti') ? 'border-red-500' : 'border-gray-300' }}">
                        @error('bukti')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div data-aos="zoom-in" data-aos-delay="600">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-bold py-3 rounded-lg shadow-lg hover:scale-105 transition">
                            Upload Pembayaran
                        </button>
                    </div>
                </form>
            </div>

            {{-- Riwayat Pembayaran --}}
            <div class="bg-white p-6 rounded-xl shadow" data-aos="fade-up" data-aos-delay="400">
                <h2 class="text-xl font-semibold mb-4">Riwayat Pembayaran</h2>

                @if ($order->pembayarans->count() > 0)
                    <div class="space-y-3">
                        @foreach ($order->pembayarans as $pay)
                            <div class="flex justify-between bg-slate-50 p-3 rounded-lg items-center" data-aos="fade-right"
                                data-aos-delay="500">
                                <div>
                                    <div class="font-bold">Rp {{ number_format($pay->pembayaran, 0, ',', '.') }}</div>
                                    <div class="text-sm text-slate-500">
                                        {{ \Carbon\Carbon::parse($pay->created_at)->format('d M Y') }}</div>
                                </div>
                                <div>
                                    @if ($pay->bukti)
                                        <a href="{{ asset('storage/' . $pay->bukti) }}" target="_blank"
                                            class="text-blue-500 underline text-sm">Lihat Bukti</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-400">Belum ada pembayaran.</p>
                @endif
            </div>

        </div>
    </section>

    {{-- Script Format dan Validasi --}}
    <script>
        const pembayaranInput = document.getElementById('pembayaran');
        const sisaPembayaran = {{ $sisa }};

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        }

        function parseRupiah(value) {
            return parseInt(value.replace(/[^0-9]/g, '') || 0);
        }

        pembayaranInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value) value = formatRupiah(value);
            e.target.value = value;
        });

        document.getElementById('formPembayaran').addEventListener('submit', function(e) {
            const pembayaran = parseRupiah(pembayaranInput.value);
            if (pembayaran > sisaPembayaran) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Pembayaran Melebihi Sisa',
                    text: `Maksimal pembayaran hanya Rp ${formatRupiah(sisaPembayaran)}`
                });
            }
        });
    </script>

@endsection
