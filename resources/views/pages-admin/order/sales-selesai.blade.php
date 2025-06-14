@extends('layouts-admin.app')

@section('content')
    <div class="space-y-6">

        {{-- Filter --}}
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-white/20 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg>
                Filter Periode
            </h2>

            <form method="GET" id="filter-form" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-3">Bulan</label>
                    <select name="bulan" class="w-full px-4 py-3 bg-white rounded-2xl border border-slate-200"
                        onchange="document.getElementById('filter-form').submit()">
                        <option value="">Pilih Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-3">Tahun</label>
                    <select name="tahun" class="w-full px-4 py-3 bg-white rounded-2xl border border-slate-200"
                        onchange="document.getElementById('filter-form').submit()">
                        <option value="">Pilih Tahun</option>
                        @for ($y = 2024; $y <= 2030; $y++)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
            </form>
        </div>

        {{-- Statistik --}}
        @if ($bulan && $tahun)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 rounded-3xl shadow-lg p-8 text-white">
                    <div class="text-sm">Total Pesanan</div>
                    <div class="text-3xl font-bold">{{ number_format($totalOrder) }}</div>
                </div>

                <div
                    class="bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 rounded-3xl shadow-lg p-8 text-white">
                    <div class="text-sm">Total Pendapatan</div>
                    <div class="text-3xl font-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-500 via-purple-600 to-purple-700 rounded-3xl shadow-lg p-8 text-white">
                    <div class="text-sm">Rata-rata Per Order</div>
                    <div class="text-3xl font-bold">Rp {{ number_format($rataRata, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mt-6">
                @forelse ($orders as $order)
                    <div
                        class="group bg-white/90 backdrop-blur-sm rounded-3xl shadow-lg border border-slate-200 hover:shadow-2xl transition-transform duration-300 hover:-translate-y-1 overflow-hidden">

                        {{-- Header --}}
                        <div
                            class="flex justify-between items-center px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50">
                            <h3 class="text-sm font-semibold text-blue-600 tracking-wide">HOPE-KDT-00{{ $order->id }}
                            </h3>
                            <span class="text-xs text-slate-500">{{ $order->created_at->format('d M Y') }}</span>
                        </div>

                        {{-- Content --}}
                        <div class="p-6 space-y-4">

                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-400">Pelanggan</div>
                                    <div class="font-semibold text-slate-700 truncate">
                                        {{ $order->pelanggan->user->name ?? '-' }}</div>
                                </div>
                            </div>

                            <div
                                class="p-4 rounded-2xl bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-100">
                                <div class="text-xs text-purple-600 mb-1">Harga order</div>
                                <div class="text-xl font-bold text-purple-700">Rp
                                    {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                            </div>

                            <div
                                class="p-4 rounded-2xl bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-100">
                                <div class="text-xs text-emerald-600 mb-1">Biaya Kirim</div>
                                <div class="text-xl font-bold text-emerald-700">Rp
                                    {{ number_format($order->pengiriman->biaya ?? 0, 0, ',', '.') }}</div>
                            </div>

                            {{-- Bukti Pembayaran --}}
                            <div
                                class="p-4 rounded-2xl bg-gradient-to-r from-slate-50 to-slate-100 border border-slate-200">
                                <div class="text-xs text-slate-600 mb-2">Bukti Pembayaran</div>

                                @if ($order->pembayarans->isNotEmpty())
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach ($order->pembayarans as $pembayaran)
                                            @if ($pembayaran->bukti)
                                                <a href="{{ asset('storage/' . $pembayaran->bukti) }}" target="_blank"
                                                    class="block overflow-hidden rounded-xl border hover:ring-2 hover:ring-blue-300 transition">
                                                    <img src="{{ asset('storage/' . $pembayaran->bukti) }}"
                                                        alt="Bukti Pembayaran" class="object-cover w-full h-24">
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center text-slate-400 text-sm italic">Belum ada bukti</div>
                                @endif
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-20 bg-white/60 backdrop-blur-sm rounded-3xl border border-white/20">
                            <svg class="w-24 h-24 text-slate-300 mx-auto mb-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />

                            </svg>
                            <h3 class="text-xl font-semibold text-slate-600 mb-2">Tidak Ada Data</h3>
                            <p class="text-slate-500">Belum ada pesanan selesai untuk periode yang dipilih.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        @endif

    </div>
@endsection
