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
                    window.location.href = "/product";
                }
            });
        </script>
    @endif

    <div class="max-w-2xl mx-auto mt-10">
        <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6 text-center">Form Tambah Produk</h2>
            <form action="{{ url('/product') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="nama" id="nama"
                        class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                {{ $errors->has('nama') ? 'border-red-500' : 'border-gray-300' }}"
                        value="{{ old('nama') }}" placeholder="Masukkan nama produk">
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <input type="text" name="harga" id="harga" inputmode="numeric"
                        class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
            {{ $errors->has('harga') ? 'border-red-500' : 'border-gray-300' }}"
                        value="{{ old('harga') }}" placeholder="Masukkan harga (contoh: Rp 2.500.000)">
                    @error('harga')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="length" class="block text-sm font-medium text-gray-700 mb-1">Panjang</label>
                        <input type="number" step="0.01" name="length" id="length"
                            class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                    {{ $errors->has('length') ? 'border-red-500' : 'border-gray-300' }}"
                            value="{{ old('length') }}" placeholder="Meter">
                        @error('length')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="width" class="block text-sm font-medium text-gray-700 mb-1">Lebar</label>
                        <input type="number" step="0.01" name="width" id="width"
                            class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                    {{ $errors->has('width') ? 'border-red-500' : 'border-gray-300' }}"
                            value="{{ old('width') }}" placeholder="Meter">
                        @error('width')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="height" class="block text-sm font-medium text-gray-700 mb-1">Tinggi</label>
                        <input type="number" step="0.01" name="height" id="height"
                            class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                    {{ $errors->has('height') ? 'border-red-500' : 'border-gray-300' }}"
                            value="{{ old('height') }}" placeholder="Meter">
                        @error('height')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status"
                        class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                {{ $errors->has('status') ? 'border-red-500' : 'border-gray-300' }}">
                        <option value="">-- Pilih Status --</option>
                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak tersedia" {{ old('status') == 'tidak tersedia' ? 'selected' : '' }}>Tidak
                            Tersedia</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                    <input type="file" name="image" id="image"
                        class="block w-full text-sm text-gray-600 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                {{ $errors->has('image') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-center pt-6">
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        Simpan
                    </button>
                </div>
            </form>
            <script>
                const hargaInput = document.getElementById('harga');
                hargaInput.addEventListener('input', function(e) {
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
