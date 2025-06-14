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
                    window.location.href = "/type";
                }
            });
        </script>
    @endif

    <div class="max-w-xl mx-auto mt-10">
        <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6 text-center">Form Edit Type Dump</h2>
            <form action="{{ url('/type/' . $type_dump->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="nama" id="nama"
                        class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
            {{ $errors->has('nama') ? 'border-red-500' : 'border-gray-300' }}"
                        value="{{ old('nama', $type_dump->nama) }}" placeholder="Masukkan nama type dump">
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                    <input type="text" name="kapasitas" id="kapasitas"
                        class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
            {{ $errors->has('kapasitas') ? 'border-red-500' : 'border-gray-300' }}"
                        value="{{ old('kapasitas', $type_dump->kapasitas) }}" placeholder="Contoh: 15 m³">
                    @error('kapasitas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <input type="text" name="harga" id="harga" inputmode="numeric"
                        class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
            {{ $errors->has('harga') ? 'border-red-500' : 'border-gray-300' }}"
                        value="{{ old('harga', 'Rp ' . number_format($type_dump->harga, 0, ',', '.')) }}"
                        placeholder="Masukkan harga">
                    @error('harga')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
            {{ $errors->has('deskripsi') ? 'border-red-500' : 'border-gray-300' }}"
                        placeholder="Deskripsi singkat">{{ old('deskripsi', $type_dump->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-center pt-6">
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        Update
                    </button>
                </div>
            </form>

            <script>
                const hargaInput = document.getElementById('harga');
                hargaInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (!value) value = '0';
                    e.target.value = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(value);
                });
            </script>
        </div>
    </div>
@endsection
