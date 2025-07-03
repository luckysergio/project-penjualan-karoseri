@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('contentweb')

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            AOS.init({
                duration: 800,
                easing: "ease-in-out",
                once: true,
                mirror: false
            });
        });
    </script>

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.all.min.js"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
            });
        @endif
    </script>

    <section class="relative bg-gradient-to-br from-violet-600 via-purple-600 to-indigo-700 text-white py-20 overflow-hidden"
        data-aos="fade-up">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
        <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-32 h-32 bg-pink-400/20 rounded-full blur-2xl animate-bounce"></div>
        <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-blue-300/15 rounded-full blur-xl animate-ping"></div>
        <div class="relative max-w-6xl mx-auto px-4 text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium">Order Management</span>
            </div>
            <div class="animate__animated animate__fadeInUp animate__delay-1s">
                <h1
                    class="text-5xl md:text-6xl font-bold mb-4 bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
                    Pesanan Saya
                </h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto leading-relaxed">
                    Pantau status pesanan dan kelola transaksi Anda dengan mudah
                </p>
            </div>
        </div>
    </section>

    <!-- Tabs -->
    <section class="py-8 bg-gradient-to-br from-slate-50 to-blue-50/50" data-aos="fade-up" data-aos-delay="100">
        <div class="max-w-6xl mx-auto px-4">
            <div class="group backdrop-blur-sm bg-white/90 rounded-2xl shadow-lg hover:shadow-2xl border border-white/50 overflow-hidden transition-all duration-500 hover:-translate-y-1"
                data-aos="fade-up" data-aos-delay="200">
                <div class="flex flex-col sm:flex-row gap-2">
                    <button onclick="showTab('berjalan')" id="tab-berjalan"
                        class="flex-1 py-4 px-6 text-center font-semibold rounded-xl transition-all duration-300 bg-gradient-to-r from-violet-600 to-indigo-600 text-white shadow-lg hover:shadow-violet-500/25">
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                            </svg>
                            <span>Pesanan Berjalan</span>
                        </div>
                    </button>
                    <button onclick="showTab('selesai')" id="tab-selesai"
                        class="flex-1 py-4 px-6 text-center font-semibold rounded-xl transition-all duration-300 text-slate-600 hover:text-violet-600 hover:bg-violet-50/50">
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                            </svg>
                            <span>Pesanan Selesai</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Order List -->
    <section class="py-12 bg-gradient-to-br from-slate-50 to-blue-50/50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4">
            {{-- Running Orders --}}
            <div id="content-berjalan" class="tab-content px-4">
                <div class="max-w-4xl mx-auto space-y-6">
                    @forelse ($orders->whereIn('status_order', ['pending','proses']) as $order)
                        @php
                            $biayaPengiriman = $order->pengiriman?->biaya ?? 0;
                            $totalTagihan = ($order->total_harga ?? 0) + $biayaPengiriman;
                            $totalBayar = $order->pembayarans?->sum('pembayaran') ?? 0;
                            $sisa = $totalTagihan - $totalBayar;
                        @endphp

                        <div class="group backdrop-blur-sm bg-white/90 rounded-2xl shadow-lg hover:shadow-2xl border border-white/50 overflow-hidden transition-all duration-500 hover:-translate-y-1"
                            data-aos="fade-up" data-aos-delay="100">
                            <div class="p-6 md:p-8">
                                {{-- Header --}}
                                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                                    <div class="flex items-center gap-4 mb-4 md:mb-0" data-aos="fade-right"
                                        data-aos-delay="200">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-slate-800">HOPE-KDT-00{{ $order->id }}</h3>
                                            @if ($order->status_order == 'pending')
                                                <span
                                                    class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 text-sm font-medium px-3 py-1 rounded-full">
                                                    <div class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></div>
                                                    Pending
                                                </span>
                                            @elseif ($order->status_order == 'proses')
                                                <span
                                                    class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-sm font-medium px-3 py-1 rounded-full">
                                                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                                    Proses
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right" data-aos="fade-left" data-aos-delay="300">
                                        <p class="text-sm text-slate-500">Total Items</p>
                                        <p class="text-2xl font-bold text-slate-800">{{ $order->detailOrders->sum('qty') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Detail Produk --}}
                                <div class="space-y-6">
                                    @foreach ($order->detailOrders as $d)
                                        <div class="p-5 bg-white rounded-2xl shadow-lg border border-slate-200 flex flex-col gap-4 md:flex-row md:justify-between md:items-start transition hover:shadow-xl"
                                            data-aos="fade-up" data-aos-delay="400">
                                            <div class="flex-1 space-y-4">
                                                {{-- Jenis Produk --}}
                                                <div class="flex flex-wrap items-center gap-2 text-sm text-slate-600">
                                                    <span
                                                        class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-medium">{{ $d->typeDump->nama }}</span>
                                                    <span class="text-slate-400">/</span>
                                                    <span
                                                        class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium">{{ $d->jenisDump->nama }}</span>
                                                    <span class="text-slate-400">/</span>
                                                    <span
                                                        class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full font-medium">{{ $d->chassis->nama }}</span>
                                                </div>

                                                {{-- Info Produk --}}
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-slate-600">
                                                    <div>Quantity: <span class="font-semibold">{{ $d->qty }}
                                                            unit</span></div>
                                                    <div>Tanggal Selesai: <span
                                                            class="font-semibold">{{ \Carbon\Carbon::parse($d->tanggal_selesai)->format('d M Y') }}</span>
                                                    </div>
                                                    @php $sales = $order->sales; @endphp
                                                    <div>Penanggung Jawab: <span
                                                            class="font-semibold">{{ $sales?->user?->name ?? '-' }}</span>
                                                    </div>
                                                    <div>Email: <span
                                                            class="font-semibold">{{ $sales?->user?->email ?? '-' }}</span>
                                                    </div>
                                                    <div>No HP: <span
                                                            class="font-semibold">{{ $sales?->no_hp ?? '-' }}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Info Pengiriman --}}
                                    <div
                                        class="mt-2 text-xs text-slate-600 bg-slate-50 rounded p-3 border border-slate-200 space-y-2 text-center">
                                        <div><span class="font-semibold">Biaya Pengiriman:</span>
                                            <span class="text-orange-600 font-semibold">Rp
                                                {{ number_format($biayaPengiriman, 0, ',', '.') }}</span>
                                        </div>
                                        <div><span class="font-semibold">Alamat Pengiriman:</span>
                                            {{ $order->pengiriman?->alamat ?? '-' }}</div>
                                        <div><span class="font-semibold">Tanggal Kirim:</span>
                                            {{ $order->pengiriman?->tanggal_kirim ? \Carbon\Carbon::parse($order->pengiriman->tanggal_kirim)->format('d M Y') : '-' }}
                                        </div>
                                        <div><span class="font-semibold">Tanggal Sampai:</span>
                                            {{ $order->pengiriman?->tanggal_sampai ? \Carbon\Carbon::parse($order->pengiriman->tanggal_sampai)->format('d M Y') : '-' }}
                                        </div>
                                        <div>
                                            <span class="font-semibold">Status Pengiriman:</span>
                                            @php
                                                $status = $order->pengiriman?->status ?? '-';
                                                $warna = match ($status) {
                                                    'persiapan' => 'bg-yellow-100 text-yellow-700',
                                                    'dikirim' => 'bg-blue-100 text-blue-700',
                                                    'selesai' => 'bg-green-100 text-green-700',
                                                    default => 'bg-gray-100 text-gray-700',
                                                };
                                            @endphp
                                            <span
                                                class="px-3 py-1 rounded-full font-medium {{ $warna }}">{{ ucfirst($status) }}</span>
                                        </div>
                                    </div>

                                    {{-- Ringkasan Pembayaran --}}
                                    <div class="mt-4 text-sm text-slate-600 space-y-1 text-center">
                                        <div>Total Tagihan: <span class="font-semibold text-blue-600">Rp
                                                {{ number_format($totalTagihan, 0, ',', '.') }}</span></div>
                                        <div>Sudah Dibayar: <span class="font-semibold text-green-600">Rp
                                                {{ number_format($totalBayar, 0, ',', '.') }}</span></div>
                                        <div>Sisa Pembayaran: <span class="font-semibold text-red-600">Rp
                                                {{ number_format($sisa, 0, ',', '.') }}</span></div>
                                    </div>


                                    <div class="text-center w-full md:w-auto space-y-4">
                                        <div class="text-2xl font-bold text-slate-800">Rp
                                            {{ number_format($sisa, 0, ',', '.') }}</div>
                                        <a href="/pembayaran/{{ $order->id }}"
                                            class="inline-block bg-gradient-to-r from-green-500 to-green-700 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-md hover:scale-105 transition transform">
                                            Lakukan Pembayaran
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16" data-aos="fade-up" data-aos-delay="150">
                            <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-slate-600 mb-2">Belum ada pesanan berjalan</h3>
                            <p class="text-slate-500">Mulai dengan membuat pesanan baru</p>
                        </div>
                    @endforelse
                </div>
            </div>


            {{-- Completed Orders --}}
            <div id="content-selesai" class="tab-content hidden space-y-6">
                @forelse ($orders->where('status_order', 'selesai') as $order)
                    <div class="group backdrop-blur-sm bg-white/90 rounded-2xl shadow-lg hover:shadow-2xl border border-white/50 overflow-hidden transition-all duration-500 hover:-translate-y-1"
                        data-aos="fade-up" data-aos-delay="100">
                        <div class="p-6 md:p-8">
                            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                                <div class="flex items-center gap-4 mb-4 md:mb-0" data-aos="fade-right"
                                    data-aos-delay="200">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-slate-800">HOPE-KDT-00{{ $order->id }}</h3>
                                        <span
                                            class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-sm font-medium px-3 py-1 rounded-full">
                                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div> Selesai
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right" data-aos="fade-left" data-aos-delay="300">
                                    <p class="text-sm text-slate-500">Total Items</p>
                                    <p class="text-2xl font-bold text-slate-800">{{ $order->detailOrders->sum('qty') }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                @foreach ($order->detailOrders as $d)
                                    <div class="p-5 bg-white rounded-2xl shadow-lg border border-slate-200 flex flex-col gap-4 md:flex-row md:justify-between md:items-start transition hover:shadow-xl"
                                        data-aos="fade-up" data-aos-delay="400">

                                        {{-- Bagian Kiri --}}
                                        <div class="flex-1 space-y-4">
                                            {{-- Nama Type / Jenis / Chassis --}}
                                            <div class="flex flex-wrap items-center gap-2 text-sm text-slate-600">
                                                <span
                                                    class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-medium">{{ $d->typeDump->nama }}</span>
                                                <span class="text-slate-400">/</span>
                                                <span
                                                    class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium">{{ $d->jenisDump->nama }}</span>
                                                <span class="text-slate-400">/</span>
                                                <span
                                                    class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full font-medium">{{ $d->chassis->nama }}</span>
                                            </div>

                                            {{-- Info Order --}}
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-slate-600">
                                                <div>Quantity: <span class="font-semibold">{{ $d->qty }} unit</span>
                                                </div>
                                                <div>Tanggal Selesai: <span
                                                        class="font-semibold">{{ \Carbon\Carbon::parse($d->tanggal_selesai)->format('d M Y') }}</span>
                                                </div>

                                                @php $sales = $order->sales; @endphp
                                                <div>Penanggung Jawab: <span
                                                        class="font-semibold">{{ $sales?->user?->name ?? '-' }}</span>
                                                </div>
                                                <div>Email: <span
                                                        class="font-semibold">{{ $sales?->user?->email ?? '-' }}</span>
                                                </div>
                                                <div>No HP: <span class="font-semibold">{{ $sales?->no_hp ?? '-' }}</span>
                                                </div>
                                            </div>

                                            <div
                                                class="mt-2 text-xs text-slate-600 bg-slate-50 rounded p-3 border border-slate-200 space-y-2">
                                                <div><span class="font-semibold">Biaya Pengiriman:</span> <span
                                                        class="text-orange-600 font-semibold">Rp
                                                        {{ number_format($order->pengiriman?->biaya ?? 0, 0, ',', '.') }}</span>
                                                </div>
                                                <div><span class="font-semibold">Alamat Pengiriman:</span>
                                                    {{ $order->pengiriman?->alamat ?? '-' }}</div>
                                                <div><span class="font-semibold">Tanggal Kirim:</span>
                                                    {{ $order->pengiriman?->tanggal_kirim ? \Carbon\Carbon::parse($order->pengiriman->tanggal_kirim)->format('d M Y') : '-' }}
                                                </div>
                                                <div><span class="font-semibold">Tanggal Sampai:</span>
                                                    {{ $order->pengiriman?->tanggal_sampai ? \Carbon\Carbon::parse($order->pengiriman->tanggal_sampai)->format('d M Y') : '-' }}
                                                </div>
                                                <div><span class="font-semibold">Status Pengiriman:</span>
                                                    @php
                                                        $status = $order->pengiriman?->status ?? '-';
                                                        $warna = match ($status) {
                                                            'persiapan' => 'bg-yellow-100 text-yellow-700',
                                                            'dikirim' => 'bg-blue-100 text-blue-700',
                                                            'selesai' => 'bg-green-100 text-green-700',
                                                            default => 'bg-gray-100 text-gray-700',
                                                        };
                                                    @endphp
                                                    <span
                                                        class="px-3 py-1 rounded-full font-medium {{ $warna }}">{{ ucfirst($status) }}</span>
                                                </div>
                                            </div>

                                            @php
                                                $biayaPengiriman = $order->pengiriman?->biaya ?? 0;
                                                $totalTagihan = ($order->total_harga ?? 0) + $biayaPengiriman;
                                                $totalBayar = $order->pembayarans?->sum('pembayaran') ?? 0;
                                                $sisa = $totalTagihan - $totalBayar;
                                            @endphp

                                            <div class="mt-4 text-sm text-slate-600 space-y-1">
                                                <div>Total Tagihan: <span class="font-semibold text-blue-600">Rp
                                                        {{ number_format($totalTagihan, 0, ',', '.') }}</span></div>
                                                <div>Sudah Dibayar: <span class="font-semibold text-green-600">Rp
                                                        {{ number_format($totalBayar, 0, ',', '.') }}</span></div>
                                                <div>Sisa Pembayaran: <span class="font-semibold text-red-600">Rp
                                                        {{ number_format($sisa, 0, ',', '.') }}</span></div>
                                            </div>

                                            <div class="mt-3 text-sm text-slate-600">
                                                <div class="font-semibold mb-1">Detail Pembayaran:</div>
                                                @if ($order->pembayarans?->count())
                                                    @foreach ($order->pembayarans as $pembayaran)
                                                        <div
                                                            class="flex items-center justify-between mb-1 px-3 py-1 bg-slate-100 rounded">
                                                            <div>Rp
                                                                {{ number_format($pembayaran->pembayaran, 0, ',', '.') }}
                                                            </div>
                                                            @if ($pembayaran->bukti)
                                                                <a href="{{ asset('storage/' . $pembayaran->bukti) }}"
                                                                    target="_blank"
                                                                    class="text-blue-500 underline text-xs">Lihat Bukti</a>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="text-slate-400">Belum ada pembayaran</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="text-right w-full md:w-auto space-y-4">
                                            <div class="text-2xl font-bold text-slate-800">
                                                Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                                            </div>

                                            <span
                                                class="inline-block bg-gradient-to-r from-gray-400 to-gray-600 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-md">
                                                Transaksi Selesai
                                            </span>

                                            <a href="{{ route('order.cetak', $order->id) }}" target="_blank"
                                                class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow transition">
                                                Cetak PDF
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16" data-aos="fade-up" data-aos-delay="150">
                        <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-600 mb-2">Belum ada pesanan selesai</h3>
                        <p class="text-slate-500">Pesanan yang selesai akan muncul disini</p>
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <section class="py-16 bg-gradient-to-br from-violet-600 via-purple-600 to-indigo-700 relative overflow-hidden"
        data-aos="fade-up" data-aos-delay="150">
        <div class="relative max-w-4xl mx-auto text-center px-4 z-10">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap untuk pesanan baru?</h2>
            <p class="text-lg text-blue-100 mb-6">Klik tombol di bawah untuk mulai memesan produk kami.</p>
            <button onclick="bukaModal()"
                class="group relative inline-flex items-center gap-3 bg-white text-violet-600 hover:text-violet-700 px-8 py-4 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-white/25 transition-all duration-300 hover:-translate-y-1 hover:scale-105">
                <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                <span>Buat Pesanan Baru</span>
            </button>
        </div>
    </section>

    <!-- Modal Form -->
    <div id="modalBuatPesanan"
        class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden items-center justify-center overflow-y-auto p-4">
        <div class="bg-white rounded-3xl w-full max-w-4xl mx-auto shadow-2xl transform transition-all duration-300 scale-95 opacity-0"
            id="modalContent" data-aos="zoom-in">
            <div
                class="flex justify-between items-center px-8 py-6 border-b bg-gradient-to-r from-violet-100 to-indigo-100 rounded-t-3xl">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">📝 Buat Pesanan Baru</h2>
                    <p class="text-slate-500 text-sm mt-1">Lengkapi data pesanan Anda dengan benar.</p>
                </div>
                <button onclick="tutupModal()"
                    class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-full transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('orders.store') }}" method="POST" class="px-8 py-6 space-y-8">
                @csrf

                <!-- Pemesan -->
                <div class="bg-indigo-50 rounded-2xl p-5">
                    <p class="text-sm font-medium text-slate-500 mb-1">Pemesan</p>
                    <p class="text-xl font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                </div>

                <!-- Detail Order -->
                <div>
                    <h3 class="text-lg font-bold text-slate-700 mb-4">📦 Detail Order</h3>
                    <div id="detail-order-wrapper" class="space-y-6">
                        <!-- Template awal -->
                        <div class="detail-item bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Type Dump</label>
                                    <select name="details[0][id_type]"
                                        class="type-select w-full rounded-lg border-slate-300" required
                                        onchange="hitungHarga(this)">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id }}" data-harga="{{ $type->harga }}">
                                                {{ $type->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Jenis Dump</label>
                                    <select name="details[0][id_jenis]" class="w-full rounded-lg border-slate-300"
                                        required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($jenis as $j)
                                            <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Chassis</label>
                                    <select name="details[0][id_chassis]" class="w-full rounded-lg border-slate-300"
                                        required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($chassis as $c)
                                            <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Jumlah</label>
                                    <input type="number" name="details[0][qty]"
                                        class="qty-input w-full rounded-lg border-slate-300" placeholder="Contoh: 2"
                                        required oninput="hitungHarga(this)">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Total Harga</label>
                                    <input type="text"
                                        class="harga-input w-full rounded-lg border-slate-300 text-right" readonly>
                                    <input type="hidden" name="details[0][harga_order]" class="harga-hidden">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Tambah Detail -->
                    <button type="button" onclick="tambahDetailOrder()"
                        class="mt-4 inline-flex items-center gap-2 text-indigo-600 font-medium hover:underline">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        Tambah Item
                    </button>
                </div>
                <!-- Footer -->
                <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-slate-200">
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md">
                        Simpan Pesanan
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        let detailCounter = 0;

        // Fungsi utama: hitung harga per detail
        function hitungHarga(detailItem) {
            const typeSelect = detailItem.querySelector('.type-select');
            const qtyInput = detailItem.querySelector('.qty-input');
            const hargaInput = detailItem.querySelector('.harga-input');

            const harga = parseInt(typeSelect.options[typeSelect.selectedIndex]?.dataset.harga || 0);
            const qty = parseInt(qtyInput.value || 0);
            hargaInput.value = harga * qty;
        }

        // Pasang event listener per detail
        function pasangEventListener(detailItem) {
            const typeSelect = detailItem.querySelector('.type-select');
            const qtyInput = detailItem.querySelector('.qty-input');

            typeSelect.addEventListener('change', () => hitungHarga(detailItem));
            qtyInput.addEventListener('input', () => hitungHarga(detailItem));
        }

        // Saat load pertama
        document.addEventListener('DOMContentLoaded', function() {
            const firstDetail = document.querySelector('.detail-item');
            if (firstDetail) {
                pasangEventListener(firstDetail);
            }
        });

        // Tambah detail order
        function tambahDetailOrder() {
            detailCounter++;
            const wrapper = document.getElementById('detail-order-wrapper');

            const newDetail = document.createElement('div');
            newDetail.className = 'detail-item bg-white rounded-xl border border-slate-200 shadow-sm p-5 mt-4 relative';
            newDetail.innerHTML = `
            <button type="button" onclick="hapusDetailOrder(this)" class="absolute top-3 right-3 w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-full flex items-center justify-center transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Type Dump</label>
                    <select name="details[${detailCounter}][id_type]" class="type-select w-full rounded-lg border-slate-300" required>
                        <option value="">-- Pilih --</option>
                        ${getTypeOptions()}
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Jenis Dump</label>
                    <select name="details[${detailCounter}][id_jenis]" class="w-full rounded-lg border-slate-300" required>
                        <option value="">-- Pilih --</option>
                        ${getJenisOptions()}
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Chassis</label>
                    <select name="details[${detailCounter}][id_chassis]" class="w-full rounded-lg border-slate-300" required>
                        <option value="">-- Pilih --</option>
                        ${getChassisOptions()}
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Jumlah</label>
                    <input type="number" name="details[${detailCounter}][qty]" class="qty-input w-full rounded-lg border-slate-300" placeholder="Contoh: 2" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Total Harga</label>
                    <input type="number" name="details[${detailCounter}][harga_order]" class="harga-input w-full rounded-lg border-slate-300" readonly>
                </div>
            </div>
        `;

            wrapper.appendChild(newDetail);
            pasangEventListener(newDetail);
        }

        // Hapus detail order
        function hapusDetailOrder(button) {
            const detailItem = button.closest('.detail-item');
            detailItem.remove();
        }

        // Modal fungsi tetap aktif
        function bukaModal() {
            const modal = document.getElementById('modalBuatPesanan');
            const modalContent = document.getElementById('modalContent');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function tutupModal() {
            const modal = document.getElementById('modalBuatPesanan');
            const modalContent = document.getElementById('modalContent');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // Klik luar modal
        document.getElementById('modalBuatPesanan').addEventListener('click', function(e) {
            if (e.target === this) {
                tutupModal();
            }
        });

        // ESC key tutup modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('modalBuatPesanan');
                if (!modal.classList.contains('hidden')) {
                    tutupModal();
                }
            }
        });

        // Fungsi generate option tetap pakai blade (server-side rendering)
        function getTypeOptions() {
            return `{!! $types->map(fn($type) => "<option value='{$type->id}' data-harga='{$type->harga}'>{$type->nama}</option>")->implode('') !!}`;
        }

        function getJenisOptions() {
            return `{!! $jenis->map(fn($j) => "<option value='{$j->id}'>{$j->nama}</option>")->implode('') !!}`;
        }

        function getChassisOptions() {
            return `{!! $chassis->map(fn($c) => "<option value='{$c->id}'>{$c->nama}</option>")->implode('') !!}`;
        }

        function showTab(tab) {
            // Sembunyikan semua tab
            document.querySelectorAll('.tab-content').forEach(function(el) {
                el.classList.add('hidden');
            });

            // Hilangkan active style semua tombol
            document.querySelectorAll('button[id^="tab-"]').forEach(function(el) {
                el.classList.remove('bg-gradient-to-r', 'from-violet-600', 'to-indigo-600', 'text-white',
                    'shadow-lg');
                el.classList.add('text-slate-600', 'hover:text-violet-600', 'hover:bg-violet-50/50');
            });

            // Tampilkan tab yang dipilih
            document.getElementById('content-' + tab).classList.remove('hidden');

            // Aktifkan style tombol yang dipilih
            let activeBtn = document.getElementById('tab-' + tab);
            activeBtn.classList.add('bg-gradient-to-r', 'from-violet-600', 'to-indigo-600', 'text-white', 'shadow-lg');
            activeBtn.classList.remove('text-slate-600', 'hover:text-violet-600', 'hover:bg-violet-50/50');
        }

        // Optional: load default tab saat halaman dibuka
        document.addEventListener("DOMContentLoaded", function() {
            showTab('berjalan');
        });

        // Format ke Rupiah
        function formatRupiah(angka) {
            let number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return 'Rp ' + rupiah;
        }

        // Hitung Total Harga setiap input berubah
        function hitungHarga(element) {
            const container = element.closest('.detail-item');
            const typeSelect = container.querySelector('.type-select');
            const qtyInput = container.querySelector('.qty-input');
            const hargaInput = container.querySelector('.harga-input');
            const hiddenInput = container.querySelector('.harga-hidden');

            const hargaSatuan = parseInt(typeSelect.options[typeSelect.selectedIndex]?.dataset?.harga || 0);
            const qty = parseInt(qtyInput.value || 0);
            const total = hargaSatuan * qty;

            hargaInput.value = formatRupiah(total);
            hiddenInput.value = total;
        }

        // Tambah item baru
        function tambahDetailOrder() {
            const wrapper = document.getElementById('detail-order-wrapper');
            const items = wrapper.querySelectorAll('.detail-item');
            const index = items.length;
            const newItem = items[0].cloneNode(true);

            // Reset input
            newItem.querySelectorAll('input, select').forEach(input => {
                if (input.type === 'text' || input.type === 'number') input.value = '';
                if (input.type === 'hidden') input.value = '0';
            });

            // Update name attribute
            newItem.querySelectorAll('select, input').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
                }
            });

            wrapper.appendChild(newItem);
        }
    </script>

@endsection
