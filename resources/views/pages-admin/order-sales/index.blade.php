@extends('layouts-admin.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100 py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="order-container">
                @if ($orders->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12 sm:py-16">
                        <div class="w-24 h-24 sm:w-32 sm:h-32 mb-6 opacity-20">
                            <svg class="w-full h-full text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div
                            class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-200 text-center max-w-md mx-auto">
                            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">
                                Belum Ada Order
                            </h3>
                            <p class="text-gray-600 text-sm sm:text-base">
                                Tidak ada order untuk ditampilkan saat ini.
                            </p>
                        </div>
                    </div>
                @else
                    <!-- Orders Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 sm:gap-6">
                        @foreach ($orders as $order)
                            @php
                                $totalProduk = $order->total_harga ?? 0;
                                $biayaPengiriman = $order->pengiriman?->biaya ?? 0;
                                $totalTagihan = $totalProduk + $biayaPengiriman;
                                $totalDibayar = $order->pembayarans->sum('pembayaran');
                                $sisa = $totalTagihan - $totalDibayar;
                                $statusColor = match ($order->status_order) {
                                    'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                    default => 'bg-gray-50 text-gray-700 border-gray-200',
                                };
                            @endphp

                            <!-- Order Card -->
                            <div
                                class="group bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg hover:border-gray-300 transition-all duration-300 overflow-hidden">
                                <!-- Card Header -->
                                <div class="p-4 sm:p-6 border-b border-gray-100">
                                    <div class="flex flex-col items-center justify-center gap-2 mb-4 text-center">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-lg bg-gray-100 text-gray-700 text-xs font-mono font-medium">
                                                HOPE-KDT-00{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </div>
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full border text-xs font-semibold {{ $statusColor }}">
                                            {{ ucfirst($order->status_order) }}
                                        </span>
                                    </div>

                                    <div class="space-y-3 ">
                                        <div class="text-center">
                                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                                                Pemesan
                                            </h3>
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $order->pelanggan->user->name }}
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                                                    Total Tagihan
                                                </h4>
                                                <p class="text-sm font-bold text-indigo-600">
                                                    Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <div>
                                                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                                                    Sisa Bayar
                                                </h4>
                                                <p
                                                    class="text-sm font-bold {{ $sisa > 0 ? 'text-red-600' : 'text-green-600' }}">
                                                    Rp {{ number_format($sisa, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-4 sm:p-6 bg-gray-50 space-y-3">
                                    <button
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-4 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 text-sm"
                                        data-modal-target="modal-{{ $order->id }}">
                                        <span class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat Detail
                                        </span>
                                    </button>

                                    <a href="/order-sales/{{ $order->id }}"
                                        class=" w-full inline-flex items-center justify-center gap-2 border border-gray-300 text-gray-700 hover:bg-white hover:border-gray-400 font-medium py-2.5 px-4 rounded-xl transition-all duration-200 text-sm bg-white/50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Proses Order
                                    </a>
                                </div>
                            </div>

                            <div id="modal-{{ $order->id }}" class="modal-overlay fixed inset-0 z-50 hidden">
                                <div class="min-h-screen flex items-center justify-center p-4">
                                    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm"
                                        onclick="closeModal({{ $order->id }})"></div>
                                    <div
                                        class="modal-content relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out">
                                        <!-- Modal Header -->
                                        <div
                                            class="relative flex items-center justify-between p-2 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-blue-50">
                                            <!-- Tombol Close -->
                                            <button onclick="closeModal({{ $order->id }})"
                                                class="flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors z-10">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                            <p
                                                class="absolute left-1/2 -translate-x-1/2 text-base text-gray-700 font-medium pt-3">
                                                HOPE-KDT-00{{ $order->id }}
                                            </p>
                                        </div>

                                        <div class="p-6 overflow-y-auto max-h-[calc(90vh-180px)]">
                                            <div class="space-y-6">
                                                <div class="bg-gray-50 rounded-xl p-4">
                                                    <h3
                                                        class="font-semibold text-base mb-3 flex items-center gap-2 text-gray-900">
                                                        <span
                                                            class="flex items-center justify-center w-6 h-6 bg-blue-100 rounded-md text-sm">👤</span>
                                                        Informasi Pemesan
                                                    </h3>
                                                    <div class="space-y-2 text-sm">
                                                        <p><span class="font-medium text-gray-700">Nama:</span>
                                                            {{ $order->pelanggan->user->name }}</p>
                                                        <p><span class="font-medium text-gray-700">Email:</span>
                                                            {{ $order->pelanggan->user->email }}</p>
                                                        <p><span class="font-medium text-gray-700">No HP:</span>
                                                            {{ $order->pelanggan->no_hp }}</p>
                                                    </div>
                                                </div>

                                                <div class="bg-green-50 rounded-xl p-4">
                                                    <h3
                                                        class="font-semibold text-base mb-3 flex items-center gap-2 text-gray-900">
                                                        <span
                                                            class="flex items-center justify-center w-6 h-6 bg-green-100 rounded-md text-sm">🛒</span>
                                                        Detail Produk
                                                    </h3>
                                                    <div class="space-y-2">
                                                        @foreach ($order->detailOrders as $detail)
                                                            <div class="bg-white rounded-lg p-3 text-sm">
                                                                <div class="font-medium text-gray-900 mb-1">
                                                                    {{ $detail->typeDump->nama }} /
                                                                    {{ $detail->jenisDump->nama }}
                                                                </div>
                                                                <div class="text-gray-600">
                                                                    Chassis: {{ $detail->chassis->nama }} • Qty:
                                                                    {{ $detail->qty }} unit
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="bg-amber-50 rounded-xl p-4">
                                                    <h3
                                                        class="font-semibold text-base mb-3 flex items-center gap-2 text-gray-900">
                                                        <span
                                                            class="flex items-center justify-center w-6 h-6 bg-amber-100 rounded-md text-sm">🚚</span>
                                                        Informasi Pengiriman
                                                    </h3>
                                                    @if ($order->pengiriman)
                                                        <div class="space-y-2 text-sm">
                                                            <p><span class="font-medium text-gray-700">Alamat:</span>
                                                                {{ $order->pengiriman->alamat }}</p>
                                                            <p><span class="font-medium text-gray-700">Tanggal Kirim:</span>
                                                                {{ $order->pengiriman->tanggal_kirim }}</p>
                                                            <p><span class="font-medium text-gray-700">Biaya
                                                                    Pengiriman:</span> Rp
                                                                {{ number_format($order->pengiriman->biaya, 0, ',', '.') }}
                                                            </p>
                                                        </div>
                                                    @else
                                                        <p
                                                            class="text-red-600 text-sm bg-red-50 border border-red-200 rounded-lg p-3">
                                                            ⚠️ Belum ada informasi pengiriman
                                                        </p>
                                                    @endif
                                                </div>

                                                <div class="bg-purple-50 rounded-xl p-4">
                                                    <h3
                                                        class="font-semibold text-base mb-3 flex items-center gap-2 text-gray-900">
                                                        <span
                                                            class="flex items-center justify-center w-6 h-6 bg-purple-100 rounded-md text-sm">💳</span>
                                                        Informasi Pembayaran
                                                    </h3>

                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                                        <div class="bg-white rounded-lg p-3">
                                                            <p class="text-gray-600 mb-1">Total Dibayar</p>
                                                            <p class="font-bold text-green-600 text-lg">
                                                                Rp {{ number_format($totalDibayar, 0, ',', '.') }}
                                                            </p>
                                                        </div>

                                                        <div class="bg-white rounded-lg p-3">
                                                            <p class="text-gray-600 mb-1">Sisa Pembayaran</p>
                                                            <p
                                                                class="font-bold {{ $sisa > 0 ? 'text-red-600' : 'text-green-600' }} text-lg">
                                                                Rp {{ number_format($sisa, 0, ',', '.') }}
                                                            </p>
                                                        </div>

                                                        {{-- Bukti Pembayaran --}}
                                                        <div class="bg-white rounded-lg p-3 col-span-1 sm:col-span-2">
                                                            <p class="text-gray-600 mb-2">Bukti Pembayaran</p>
                                                            @if ($order->pembayarans->isNotEmpty())
                                                                <div class="flex flex-wrap gap-3">
                                                                    @foreach ($order->pembayarans as $pembayaran)
                                                                        @if ($pembayaran->bukti)
                                                                            <a href="{{ asset('storage/' . $pembayaran->bukti) }}"
                                                                                target="_blank"
                                                                                class="inline-block border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow transition">
                                                                                <img src="{{ asset('storage/' . $pembayaran->bukti) }}"
                                                                                    alt="Bukti"
                                                                                    class="h-24 w-auto object-cover">
                                                                            </a>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <p class="text-red-500 italic">Belum ada bukti pembayaran.
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex justify-center gap-4 p-6 border-t border-gray-200 bg-gray-50">
                                            <button onclick="closeModal({{ $order->id }})"
                                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2.5 px-6 rounded-xl transition-colors">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (!$orders->isEmpty())
                    <div class="mt-8 flex justify-center">
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-2">
                            {{ $orders->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-modal-target]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-modal-target');
                    openModal(modalId);
                });
            });

            document.querySelectorAll('.modal-overlay').forEach(overlay => {
                overlay.addEventListener('click', function(e) {
                    if (e.target === this) {
                        const modalId = this.id;
                        const orderId = modalId.replace('modal-', '');
                        closeModal(orderId);
                    }
                });
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const openModal = document.querySelector('.modal-overlay:not(.hidden)');
                    if (openModal) {
                        const orderId = openModal.id.replace('modal-', '');
                        closeModal(orderId);
                    }
                }
            });
        });

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = modal.querySelector('.modal-content');

            if (!modal || !content) return;

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal(id) {
            const modal = document.getElementById('modal-' + id);
            const content = modal?.querySelector('.modal-content');

            if (!modal || !content) return;

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }

        document.querySelectorAll('a[href*="/order-sales/"]').forEach(link => {
            link.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = `
                    <span class="flex items-center justify-center gap-2">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    </span>
                `;
                this.classList.add('pointer-events-none', 'opacity-75');
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Custom scrollbar for modal */
        .modal-content {
            scrollbar-width: thin;
            scrollbar-color: #CBD5E1 #F1F5F9;
        }

        .modal-content::-webkit-scrollbar {
            width: 6px;
        }

        .modal-content::-webkit-scrollbar-track {
            background: #F1F5F9;
            border-radius: 3px;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 3px;
        }

        .modal-content::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }

        /* Smooth transitions for all interactive elements */
        .group:hover .group-hover\:translate-x-1 {
            transform: translateX(0.25rem);
        }

        /* Enhanced focus states */
        button:focus-visible,
        a:focus-visible {
            outline: 2px solid #6366F1;
            outline-offset: 2px;
        }
    </style>
@endpush
