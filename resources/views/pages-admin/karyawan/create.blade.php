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
                    window.location.href = "/karyawan";
                }
            });
        </script>
    @endif

    <div class="max-w-2xl mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6 text-center">Form Tambah Karyawan</h2>
        <form action="{{ url('/karyawan') }}" method="POST" class="space-y-5">
            @csrf
            @method('POST')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" id="name"
                    class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                    {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                    value="{{ old('name') }}" placeholder="Masukkan nama">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email"
                    class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                    {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}"
                    value="{{ old('email') }}" placeholder="Masukkan email">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password"
                    class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                    {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}"
                    placeholder="Minimal 8 karakter">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                <input type="text" name="nik" id="nik"
                    class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                    {{ $errors->has('nik') ? 'border-red-500' : 'border-gray-300' }}"
                    value="{{ old('nik') }}" placeholder="Masukkan NIK karyawan">
                @error('nik')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3"
                    class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                    {{ $errors->has('alamat') ? 'border-red-500' : 'border-gray-300' }}"
                    placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                <input type="text" name="no_hp" id="no_hp"
                    class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                    {{ $errors->has('no_hp') ? 'border-red-500' : 'border-gray-300' }}"
                    value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
                @error('no_hp')
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
    </div>
</div>
@endsection
