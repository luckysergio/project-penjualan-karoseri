<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PT. HARAPAN DUTA PERTIWI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#8B5CF6',
                            600: '#7C3AED',
                            700: '#6D28D9'
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.min.css" rel="stylesheet" />
 
    {{-- @vite('resources/css/app.css') --}}
</head>

<body
    class="min-h-screen bg-gradient-to-br from-purple-600 via-purple-700 to-pink-500 flex items-center justify-center p-4">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-purple-900/20 via-transparent to-pink-900/20"></div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl animate-pulse"></div>
    <div class="absolute top-32 right-20 w-16 h-16 bg-white/5 rounded-full blur-lg animate-pulse delay-300"></div>
    <div class="absolute bottom-20 left-1/4 w-24 h-24 bg-white/5 rounded-full blur-xl animate-pulse delay-700"></div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.all.min.js"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('success')),
                confirmButtonColor: '#2563eb',
                didClose: () => {
                    window.location.href = "/login";
                }
            });
        </script>
    @endif

    <div class="relative w-full max-w-md">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-lg rounded-full mb-4">
                <i class="fas fa-shipping-fast text-2xl text-white"></i>
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">PT. HARAPAN DUTA PERTIWI</h1>
        </div>

        <!-- Login Form -->
        <div class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-white/20">
            <form action="/register" method="POST" class="space-y-6">
                @csrf
                @method('POST')

                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-user-tag mr-2 text-purple-600"></i>Nama
                    </label>
                    <div class="relative">
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 backdrop-blur-sm {{ $errors->has('name') ? 'border-red-500' : '' }}"
                            placeholder="Masukkan nama Anda" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-id-card text-gray-400"></i>
                        </div>
                    </div>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-envelope mr-2 text-purple-600"></i>Email
                    </label>
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 backdrop-blur-sm {{ $errors->has('email') ? 'border-red-500' : '' }}"
                            placeholder="Masukkan email Anda" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock mr-2 text-purple-600"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 backdrop-blur-sm {{ $errors->has('password') ? 'border-red-500' : '' }}"
                            placeholder="Masukkan password Anda" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword()"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-br from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white py-3 px-6 rounded-xl font-semibold shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200 ease-in-out flex items-center justify-center gap-2">
                    <i class="fas fa-user-plus text-white text-base"></i>
                    <span class="text-base">Daftar</span>
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    
                    <a href="/login" class="font-medium text-purple-600 hover:text-purple-800 transition-colors">
                        Kembali ke login
                    </a>
                </p>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="mt-6 text-center">
            <a href="/#" class="inline-flex items-center text-white/80 hover:text-white transition-colors text-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    @if (session('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Add loading state to login button
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Memproses...</span>';
            button.disabled = true;
        });
    </script>
</body>

</html>
