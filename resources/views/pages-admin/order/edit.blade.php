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
                    window.location.href = "/order";
                }
            });
        </script>
    @endif

    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Tentukan Sales</h2>

        <form action="{{ route('order.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="id_sales" class="block mb-2 font-medium">Pilih Sales:</label>
                <select name="id_sales" id="id_sales" class="w-full border rounded-lg p-2">
                    <option value="">-- Pilih Sales --</option>
                    @foreach ($sales as $s)
                        <option value="{{ $s->id }}" {{ $order->id_sales == $s->id ? 'selected' : '' }}>
                            {{ $s->user->name }} ({{ $s->nik }})
                        </option>
                    @endforeach
                </select>

                @error('id_sales')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="/order" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
