@extends('layouts.app')

@section('title', 'Profile Saya')

@section('contentweb')

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.all.min.js"></script>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `
            <ul style="text-align: left;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        `
            });
        </script>
    @endif

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
            });
        @endif
    </script>

    <!-- Page Header -->
    <section class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white py-16 sm:py-20">

        <div class="animate__animated animate__fadeInUp animate__delay-1s">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4">
                        Profile Saya
                    </h1>
                    <p class="text-lg sm:text-xl opacity-90 max-w-2xl mx-auto">
                        Kelola informasi pribadi dan pengaturan akun Anda
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Profile Content -->
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="animate__animated animate__fadeInUp animate__delay-2s">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-8">
                        <div class="flex flex-col sm:flex-row items-center">
                            <!-- Profile Avatar -->
                            <div class="relative mb-4 sm:mb-0 sm:mr-6">
                                <div class="w-24 h-24 bg-white rounded-full shadow-lg flex items-center justify-center">
                                    <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <!-- Profile Info -->
                            <div class="text-center sm:text-left text-white">
                                <h2 class="text-2xl font-bold mb-1">{{ auth()->user()->name }}</h2>
                                <p class="text-indigo-100 mb-2">{{ auth()->user()->email }}</p>
                                <div class="flex items-center justify-center sm:justify-start">
                                    <svg class="w-4 h-4 mr-2 text-indigo-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm text-indigo-200">
                                        Bergabung sejak {{ auth()->user()->created_at->translatedFormat('F Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Profile Tabs -->
            <div class="animate__animated animate__fadeInUp animate__delay-3s">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-2 mb-8">
                    <div class="flex space-x-2" role="tablist">
                        <button onclick="showProfileTab('personal')" id="tab-personal"
                            class="flex-1 py-3 px-4 text-center font-medium rounded-lg transition-all duration-200 bg-indigo-600 text-white shadow-sm">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Data Pribadi
                            </span>
                        </button>
                        <button onclick="showProfileTab('keamanan')" id="tab-keamanan"
                            class="flex-1 py-3 px-4 text-center font-medium rounded-lg transition-all duration-200 text-gray-600 hover:text-indigo-600 hover:bg-gray-50">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Keamanan
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Personal Data Tab -->
            <div id="content-personal" class="profile-tab-content">
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden" data-aos="fade-up"
                    data-aos-duration="1000">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h3>
                        <p class="text-sm text-gray-600">Kelola informasi dasar akun Anda</p>
                    </div>
                    <div class="p-6">
                        <form action="{{ url('/profile/' . auth()->user()->id) }}" method="POST" class="needs-validation"
                            novalidate>
                            @csrf
                            @method('PUT')
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">No Handphone</label>
                                    <input type="text" name="no_hp" id="no_hp"
                                        value="{{ old('no_hp', $pelanggan->no_hp ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Perusahaan</label>
                                    <input type="text" name="instansi" id="instansi"
                                        value="{{ old('instansi', $pelanggan->instansi ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                </div>
                            </div>

                            <div class="flex justify-center pt-4">
                                <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 transform hover:scale-105">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Security Tab -->
            <div id="content-keamanan" class="profile-tab-content hidden">
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Ubah Password</h3>
                            <p class="text-sm text-gray-600">Pastikan akun Anda aman dengan password yang kuat</p>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('password.update') }}" method="POST" class="needs-validation"
                                novalidate>
                                @csrf

                                <div class="mb-4 relative">
                                    <label for="current_password"
                                        class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center top-9">
                                        <button type="button"
                                            onclick="togglePassword('current_password', 'icon_current')"
                                            class="text-gray-400 hover:text-gray-600 transition-colors">
                                            <i class="fas fa-eye" id="icon_current"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4 relative">
                                    <label for="new_password"
                                        class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                    <input type="password" name="new_password" id="new_password"
                                        class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center top-9">
                                        <button type="button" onclick="togglePassword('new_password', 'icon_new')"
                                            class="text-gray-400 hover:text-gray-600 transition-colors">
                                            <i class="fas fa-eye" id="icon_new"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4 relative">
                                    <label for="new_password_confirmation"
                                        class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password
                                        Baru</label>
                                    <input type="password" name="new_password_confirmation"
                                        id="new_password_confirmation"
                                        class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center top-9">
                                        <button type="button"
                                            onclick="togglePassword('new_password_confirmation', 'icon_confirm')"
                                            class="text-gray-400 hover:text-gray-600 transition-colors">
                                            <i class="fas fa-eye" id="icon_confirm"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex justify-center pt-4">
                                    <button type="submit"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 transform hover:scale-105">
                                        Ubah Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    function togglePassword(inputId, iconId) {
                        const input = document.getElementById(inputId);
                        const icon = document.getElementById(iconId);

                        if (input.type === "password") {
                            input.type = "text";
                            icon.classList.remove("fa-eye");
                            icon.classList.add("fa-eye-slash");
                        } else {
                            input.type = "password";
                            icon.classList.remove("fa-eye-slash");
                            icon.classList.add("fa-eye");
                        }
                    }
                </script>
            </div>

        </div>
    </section>

    <!-- Profile Tab Switching Script -->
    <script>
        function showProfileTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.profile-tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Show selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');

            // Update tab buttons
            const tabButtons = document.querySelectorAll('[id^="tab-"]');
            tabButtons.forEach(button => {
                button.classList.remove('bg-indigo-600', 'text-white', 'shadow-sm');
                button.classList.add('text-gray-600', 'hover:text-indigo-600', 'hover:bg-gray-50');
            });

            // Activate selected tab button
            const selectedButton = document.getElementById('tab-' + tabName);
            selectedButton.classList.remove('text-gray-600', 'hover:text-indigo-600', 'hover:bg-gray-50');
            selectedButton.classList.add('bg-indigo-600', 'text-white', 'shadow-sm');
        }
    </script>
@endsection
