@extends('layouts-admin.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Produk</h1>
        <a href="/product/create"
            class="inline-flex items-center justify-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 active:from-blue-700 active:to-blue-800
            text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 ease-in-out border border-blue-400 hover:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-200"><i
                class="fas fa-plus"></i>
            <span>Tambah Produk</span>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.all.min.js"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('success')),
                didClose: () => {
                    window.location.href = "/product";
                }
            });
        </script>
    @endif

    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-10">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-center">Nama</th>
                        <th class="px-6 py-4 text-center">Panjang</th>
                        <th class="px-6 py-4 text-center">Lebar</th>
                        <th class="px-6 py-4 text-center">Tinggi</th>
                        <th class="px-6 py-4 text-center">Harga</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700">
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-center font-medium">{{ $product->nama }}</td>
                            <td class="px-6 py-4 text-center">{{ $product->length ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">{{ $product->width ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">{{ $product->height ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">Rp.{{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex px-3 py-1 rounded-full text-xs font-semibold text-white
                                {{ $product->status === 'tersedia' ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="/product/{{ $product->id }}"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-full text-white shadow transition"
                                        style="background-color: #facc15;">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <button onclick="confirmDelete('{{ $product->id }}', '{{ $product->nama }}')"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-full text-white shadow transition"
                                        style="background-color: #dc2626; border-radius: 9999px;"
                                        onmouseover="this.style.backgroundColor='#b91c1c'"
                                        onmouseout="this.style.backgroundColor='#dc2626'">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-400 italic">
                                Tidak ada data produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus Produk?',
                text: `Yakin ingin menghapus "${name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/product/${id}`;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';

                    form.appendChild(csrf);
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
