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
                    window.location.href = "/pengiriman";
                }
            });
        </script>
    @endif

    <div class="max-w-xl mx-auto mt-10">
        <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6 text-center">Edit Pengiriman</h2>
            <form action="/pengiriman/{{ $pengiriman->id }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3"
                        class="w-full px-4 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('alamat', $pengiriman->alamat) }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="biaya" class="block text-sm font-medium text-gray-700 mb-1">Biaya Pengiriman</label>
                    <input type="text" name="biaya" id="biaya" inputmode="numeric"
                        class="w-full px-4 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500"
                        value="{{ old('biaya', number_format($pengiriman->biaya, 0, ',', '.')) }}">
                    @error('biaya')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_kirim" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kirim</label>
                    <input type="date" name="tanggal_kirim" id="tanggal_kirim"
                        class="w-full px-4 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500"
                        value="{{ old('tanggal_kirim', $pengiriman->tanggal_kirim) }}">
                    @error('tanggal_kirim')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_sampai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai"
                        class="w-full px-4 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500"
                        value="{{ old('tanggal_sampai', $pengiriman->tanggal_sampai) }}">
                    @error('tanggal_sampai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status"
                        class="w-full px-4 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500">
                        @foreach (['persiapan', 'dikirim', 'selesai'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $pengiriman->status) == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-center pt-6">
                    <button type="submit"
                        class="px-6 py-3 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 transition">
                        Update
                    </button>
                </div>
            </form>

            <script>
                const biayaInput = document.getElementById('biaya');
                biayaInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    let formatted = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(value);
                    e.target.value = formatted;
                });
            </script>
        </div>
    </div>
@endsection
