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
                                    Proses
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
                                @else
                                    <p class="text-red-500 font-semibold">Belum Ditentukan</p>
                                @endif
                            </div>
    
                            <div class="mb-4">
                                <h3 class="font-semibold text-slate-700 mb-1">Total Harga</h3>
                                <p class="text-blue-600 text-xl font-bold">Rp
                                    {{ number_format($order->total_harga, 0, ',', '.') }}</p>
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
