@extends('layouts-admin.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div id="pengiriman-container">

            @if ($pengirimans->isEmpty())
                <div class="p-6 bg-yellow-100 text-yellow-700 rounded-lg text-center shadow">
                    Tidak ada pengiriman saat ini.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($pengirimans as $pengiriman)
                        <div
                            class="p-5 bg-white rounded-2xl shadow-lg border border-slate-200 transition hover:scale-[1.02] duration-200">

                            <div class="flex justify-between items-center mb-4">
                                <span
                                    class="text-xs sm:text-sm text-slate-500">HOPE-KDT-00{{ $pengiriman->order->id }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-600">
                                    {{ ucfirst($pengiriman->status) }}
                                </span>
                            </div>

                            <div class="mb-5">
                                <h3 class="font-semibold text-slate-700 mb-1">Alamat Tujuan</h3>
                                <p class="text-slate-600 text-sm">{{ $pengiriman->alamat }}</p>
                            </div>

                            <div class="mb-5">
                                <h3 class="font-semibold text-slate-700 mb-1">Biaya Pengiriman</h3>
                                <p class="text-blue-600 text-xl font-bold">Rp
                                    {{ number_format($pengiriman->biaya, 0, ',', '.') }}</p>
                            </div>

                            <div class="mb-5">
                                <h3 class="font-semibold text-slate-700 mb-1">Jadwal</h3>
                                <p class="text-sm text-slate-600">Tanggal Kirim:
                                    {{ $pengiriman->tanggal_kirim ? \Carbon\Carbon::parse($pengiriman->tanggal_kirim)->format('d M Y') : '-' }}
                                </p>
                                <p class="text-sm text-slate-600">Tanggal Sampai:
                                    {{ $pengiriman->tanggal_sampai ? \Carbon\Carbon::parse($pengiriman->tanggal_sampai)->format('d M Y') : '-' }}
                                </p>
                            </div>

                            <div class="mb-5">
                                <h3 class="font-semibold text-slate-700 mb-1">Sales</h3>
                                <p class="text-sm text-slate-600">{{ $pengiriman->order->sales->user->name }}</p>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-4 flex justify-end">
                {{ $pengirimans->links() }}
            </div>

        </div>
    </div>
@endsection
