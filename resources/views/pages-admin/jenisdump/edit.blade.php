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
                window.location.href = "/jenis";
            }
        });
    </script>
@endif

<div class="max-w-xl mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6 text-center">Edit Jenis</h2>
        <form action="{{ url('/jenis/'.$jenis_dump->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Jenis</label>
                <input type="text" name="nama" id="nama"
                    class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                    {{ $errors->has('nama') ? 'border-red-500' : 'border-gray-300' }}"
                    value="{{ old('nama', $jenis_dump->nama) }}">
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                    class="block w-full px-4 py-2 text-sm border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                    {{ $errors->has('deskripsi') ? 'border-red-500' : 'border-gray-300' }}">{{ old('deskripsi', $jenis_dump->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-center pt-6">
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
