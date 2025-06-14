@extends('layouts-admin.app')

@section('content')
    <div class="container mx-auto p-4">

        <div id="order-container">

            @if ($orders->isEmpty())
                <div class="p-6 bg-yellow-100 text-yellow-700 rounded-lg text-center">
                    Tidak ada order pending saat ini.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($orders as $order)
                        <div
                            class="p-5 bg-white rounded-2xl shadow-lg border border-slate-200 transition hover:scale-[1.02] duration-200">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm text-slate-500">HOPE-KDT-00{{ $order->id }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-600">
                                    Pending
                                </span>
                            </div>
    
                            <div class="mb-4">
                                <h3 class="font-semibold text-slate-700 mb-1">Pemesan</h3>
                                <p class="text-slate-700">{{ $order->pelanggan->user->name }}</p>
                                <p class="text-slate-500 text-sm">{{ $order->pelanggan->user->email }}</p>
                                <p class="text-slate-500 text-sm">No HP: {{ $order->pelanggan->no_hp }}</p>
                                <p class="text-slate-500 text-sm">Instansi: {{ $order->pelanggan->instansi }}</p>
                            </div>
    
                            <div class="mb-4">
                                <h3 class="font-semibold text-slate-700 mb-1">Sales</h3>
                                @if ($order->sales)
                                    <p class="text-slate-700">{{ $order->sales->user->name }}</p>
                                    <p class="text-slate-500 text-sm">{{ $order->sales->user->email }}</p>
                                    <p class="text-slate-500 text-sm">{{ $order->sales->no_hp }}</p>
                                @else
                                    <p class="text-red-500 font-semibold">Belum Ditentukan</p>
                                @endif
                            </div>
    
                            <div class="mb-4">
                                <h3 class="font-semibold text-slate-700 mb-1">Detail Order</h3>
                                @foreach ($order->detailOrders as $detail)
                                    <div class="bg-slate-50 rounded-lg p-3 mb-2 border">
                                        <div class="flex flex-col gap-1 text-sm text-slate-600">
                                            <div><span class="font-semibold">Type:</span> {{ $detail->typeDump->nama }}</div>
                                            <div><span class="font-semibold">Jenis:</span> {{ $detail->jenisDump->nama }}</div>
                                            <div><span class="font-semibold">Chassis:</span> {{ $detail->chassis->nama }}</div>
                                            <div><span class="font-semibold">Qty:</span> {{ $detail->qty }} unit</div>
                                            <div><span class="font-semibold">Harga Order:</span> Rp
                                                {{ number_format($detail->harga_order, 0, ',', '.') }}</div>
                                            <div><span class="font-semibold">Selesai:</span>
                                                {{ $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->format('d M Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
    
                            <div class="mb-4">
                                <h3 class="font-semibold text-slate-700 mb-1">Total Harga</h3>
                                <p class="text-blue-600 text-xl font-bold">Rp
                                    {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            </div>
    
                            <div class="flex flex-col gap-3">
                                <a href="{{ route('order.edit', $order->id) }}"
                                    class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 active:from-blue-700 active:to-blue-800 
            text-white font-semibold text-center py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 ease-in-out 
            border border-blue-400 hover:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-200">
                                    Proses Order
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="mt-4 items-center">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');

            $.get(url, function(data) {
                $('#order-container').html($(data).find('#order-container').html());
            });
        });
    </script>
@endpush
