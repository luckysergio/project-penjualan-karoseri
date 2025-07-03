@extends('layouts.app')

@section('title', 'Beranda')

@section('contentweb')

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <section
        class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white py-24 sm:py-32 overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute inset-0">
            <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute top-32 right-20 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute bottom-20 left-32 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
        </div>

        <div class="animate__animated animate__fadeInUp animate__delay-1s">
            <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    Selamat Datang di
                    <span class="block bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                        PT. HARAPAN DUTA PERTIWI
                    </span>
                </h1>
                <p class="text-lg sm:text-xl lg:text-2xl font-light leading-relaxed mb-10 max-w-4xl mx-auto opacity-90">
                    PT. Harapan Duta Pertiwi adalah <strong>perusahaan karoseri</strong> profesional yang bergerak dalam
                    pembuatan dan modifikasi <strong>dump truck, trailer, tangki, wingbox, serta kendaraan niaga
                        lainnya</strong>. Dengan teknologi modern, tim ahli berpengalaman, serta standar kualitas tinggi,
                    kami melayani kebutuhan industri <strong>pertambangan, konstruksi, logistik, dan transportasi</strong>
                    di seluruh Indonesia.
                </p>
                <a href="#produk"
                    class="inline-flex items-center bg-white text-indigo-600 px-8 py-4 rounded-full shadow-2xl hover:shadow-3xl hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 font-semibold text-lg group">
                    <span>Lihat Produk Unggulan</span>
                    <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <section id="spk" class="py-20 sm:py-24 bg-gradient-to-br from-indigo-50 to-white min-h-screen flex items-center">
        <div class="max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-duration="1000">

            <!-- Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-indigo-700 mb-3" data-aos="fade-up" data-aos-duration="1000">
                    Hasil SPK Weighted Product
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto rounded-full mb-4"></div>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="300">
                    Visualisasi hasil perhitungan dan peringkat produk berdasarkan metode Weighted Product.
                </p>
            </div>

            <!-- Grafik -->
            <div class="bg-white/50 backdrop-blur-md shadow-2xl rounded-3xl p-8" data-aos="zoom-in"
                data-aos-duration="1500">
                <div class="relative w-full h-[500px] sm:h-[400px]">
                    <canvas id="spkChart"></canvas>
                </div>
            </div>

        </div>
    </section>

    @push('scripts')
        <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
        <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const hasil = {!! json_encode($hasil) !!};

            if (hasil.length === 0) {
                document.getElementById('spkChart').parentNode.innerHTML = `
                <div class="flex justify-center items-center h-[400px] text-gray-500 text-xl rounded-lg bg-white shadow">
                    Tidak ada data SPK untuk ditampilkan.
                </div>
            `;
            } else {
                const labels = hasil.map(item => item.type);
                const data = hasil.map(item => parseFloat(item.V.toFixed(4)));

                const ctx = document.getElementById('spkChart').getContext('2d');
                const gradientColors = [
                    'rgba(99, 102, 241, 0.9)', // indigo
                    'rgba(139, 92, 246, 0.9)', // purple
                    'rgba(34, 197, 94, 0.9)', // green
                    'rgba(245, 158, 11, 0.9)', // amber
                    'rgba(239, 68, 68, 0.9)', // red
                    'rgba(14, 165, 233, 0.9)' // sky
                ];

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Weighted Product Score',
                            data: data,
                            backgroundColor: gradientColors.slice(0, data.length),
                            borderRadius: 15,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1500,
                            easing: 'easeOutElastic'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `Skor: ${context.formattedValue}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value.toFixed(2);
                                    }
                                }
                            }
                        }
                    }
                });
            }
        </script>
    @endpush

    <section id="produk-unggulan" class="py-20 sm:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4" data-aos="fade-up" data-aos-duration="1000">
                    Produk Unggulan Kami
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto rounded-full mb-6"
                    data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="400">
                    Jelajahi koleksi lengkap produk berkualitas tinggi kami yang telah dipercaya oleh berbagai industri di
                    seluruh Indonesia
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($products as $product)
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden"
                        data-aos="fade-up" data-aos-duration="800" data-aos-delay="{{ $loop->index * 100 }}">

                        <!-- Product Image -->
                        <div class="relative overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 h-64">
                            @if ($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->nama }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500 text-sm">No Image</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="absolute top-4 right-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold {{ $product->status === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-6">
                            <h3
                                class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors duration-300">
                                {{ $product->nama }}
                            </h3>

                            <!-- Dimensions -->
                            @if ($product->length || $product->width || $product->height)
                                <div class="flex items-center mb-3 text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                                        </path>
                                    </svg>
                                    <span>
                                        @if ($product->length)
                                            {{ $product->length }}m
                                        @endif
                                        @if ($product->width)
                                            × {{ $product->width }}m
                                        @endif
                                        @if ($product->height)
                                            × {{ $product->height }}m
                                        @endif
                                    </span>
                                </div>
                            @endif

                            <!-- Price -->
                            <div class="flex items-center justify-between">
                                <div class="text-2xl font-bold text-indigo-600">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="text-6xl mb-4 opacity-50">📦</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Produk</h3>
                        <p class="text-gray-600">Produk akan segera hadir. Silakan cek kembali nanti.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="produk" class="py-20 sm:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4" data-aos="fade-up"
                    data-aos-duration="1000">
                    Informasi Produk Lengkap
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mb-6" data-aos="fade-up"
                    data-aos-duration="1000" data-aos-delay="200"></div>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="400">
                    Pelajari lebih lanjut tentang berbagai jenis, tipe, dan chassis yang tersedia
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300"
                    data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Tipe Dump Truck</h3>
                    </div>

                    <div class="space-y-4">
                        @forelse ($type_dumps as $type)
                            <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-semibold text-gray-900">{{ $type->nama }}</h4>
                                    @if ($type->kapasitas)
                                        <span
                                            class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                            {{ $type->kapasitas }}
                                        </span>
                                    @endif
                                </div>
                                @if ($type->deskripsi)
                                    <p class="text-gray-600 text-sm leading-relaxed mb-2">{{ $type->deskripsi }}</p>
                                @endif
                                <p class="text-sm text-gray-700 font-semibold text-center">
                                    Harga: <span
                                        class="text-green-600">{{ 'Rp ' . number_format($type->harga, 0, ',', '.') }}</span>
                                </p>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="text-4xl mb-2 opacity-50">🏗️</div>
                                <p class="text-gray-500">Belum ada tipe dump truck tersedia</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300"
                    data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Jenis Dump Truck</h3>
                    </div>

                    <div class="space-y-4">
                        @forelse ($jenis_dumps as $jenis)
                            <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <h4 class="font-semibold text-gray-900 mb-2">{{ $jenis->nama }}</h4>
                                @if ($jenis->deskripsi)
                                    <p class="text-gray-600 text-sm leading-relaxed">{{ $jenis->deskripsi }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="text-4xl mb-2 opacity-50">🚛</div>
                                <p class="text-gray-500">Belum ada jenis dump truck tersedia</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300"
                    data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Chassis</h3>
                    </div>

                    <div class="space-y-4">
                        @forelse ($chassis as $chasis)
                            <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <h4 class="font-semibold text-gray-900 mb-2">{{ $chasis->nama }}</h4>
                                @if ($chasis->deskripsi)
                                    <p class="text-gray-600 text-sm leading-relaxed">{{ $chasis->deskripsi }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="text-4xl mb-2 opacity-50">⚙️</div>
                                <p class="text-gray-500">Belum ada chassis tersedia</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4" data-aos="fade-up"
                    data-aos-duration="1000">
                    Mengapa Memilih Kami?
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mb-6" data-aos="fade-up"
                    data-aos-duration="1000" data-aos-delay="200"></div>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="400">
                    Kami memberikan layanan terbaik dengan komitmen penuh untuk kepuasan pelanggan
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                <div class="text-center group" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="relative mx-auto w-20 h-20 mb-6">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl transform rotate-6 group-hover:rotate-12 transition-transform duration-300">
                        </div>
                        <div class="relative bg-white rounded-2xl shadow-lg p-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3
                        class="text-xl font-bold mb-3 text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">
                        Layanan Cepat
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        Distribusi barang yang cepat dan tepat waktu serta memastikan
                        pengiriman sampai tujuan.
                    </p>
                </div>

                <div class="text-center group" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <div class="relative mx-auto w-20 h-20 mb-6">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-green-500 to-blue-500 rounded-2xl transform rotate-6 group-hover:rotate-12 transition-transform duration-300">
                        </div>
                        <div class="relative bg-white rounded-2xl shadow-lg p-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3
                        class="text-xl font-bold mb-3 text-gray-900 group-hover:text-green-600 transition-colors duration-200">
                        Tim Profesional
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        Didukung oleh tenaga kerja yang handal, berpengalaman, dan profesional dengan sertifikasi
                        internasional.
                    </p>
                </div>

                <div class="text-center group" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
                    <div class="relative mx-auto w-20 h-20 mb-6">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl transform rotate-6 group-hover:rotate-12 transition-transform duration-300">
                        </div>
                        <div class="relative bg-white rounded-2xl shadow-lg p-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3
                        class="text-xl font-bold mb-3 text-gray-900 group-hover:text-purple-600 transition-colors duration-200">
                        Jangkauan Luas
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        Melayani pengiriman ke seluruh wilayah Indonesia dengan jaringan distribusi yang luas dan
                        terpercaya.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
