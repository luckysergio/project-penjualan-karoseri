@extends('layouts-admin.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.all.min.js"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('success')),
                confirmButtonColor: '#2563eb',
                didClose: () => {
                    window.location.href = "/order-sales";
                }
            });
        </script>
    @endif

    <div class="max-w-3xl mx-auto mt-10">
        <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6 text-center">HOPE-KDT-00{{ $order->id }}</h2>

            <form action="{{ url('/order-sales/' . $order->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="status_order" class="block text-sm font-medium text-gray-700 mb-1">Status Order</label>
                    <select name="status_order" id="status_order"
                        class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition {{ $errors->has('status_order') ? 'border-red-500' : 'border-gray-300' }}">
                        <option value="pending" {{ $order->status_order == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="proses" {{ $order->status_order == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ $order->status_order == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" {{ $order->status_order == 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                    @error('status_order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai Order (Global)</label>
                    <div class="px-4 py-2 bg-slate-100 rounded-lg border text-gray-700">
                        {{ $order->tanggal_selesai ? \Carbon\Carbon::parse($order->tanggal_selesai)->format('d-m-Y') : '-' }}
                    </div>
                </div>

                <div class="space-y-5">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Detail Order</h3>

                    @foreach ($order->detailOrders as $index => $detail)
                        <div class="p-4 bg-slate-50 rounded-lg border">
                            <p class="mb-2 font-semibold text-slate-600">Type: {{ $detail->typeDump->nama }} | Jenis: {{ $detail->jenisDump->nama }} | Chassis: {{ $detail->chassis->nama }}</p>

                            <label for="tanggal_selesai_{{ $detail->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Selesai
                            </label>
                            <input type="date" name="tanggal_selesai[{{ $detail->id }}]" id="tanggal_selesai_{{ $detail->id }}"
                                class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition {{ $errors->has('tanggal_selesai.' . $detail->id) ? 'border-red-500' : 'border-gray-300' }}"
                                value="{{ old('tanggal_selesai.' . $detail->id, $detail->tanggal_selesai) }}">
                            @error('tanggal_selesai.' . $detail->id)
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-center pt-6">
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
