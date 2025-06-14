<nav class="bg-white/95 backdrop-blur-md shadow-lg fixed w-full z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <h1
                    class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    PT. HARAPAN DUTA PERTIWI
                </h1>
            </div>

            <!-- Desktop Menu -->
            @auth
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/"
                        class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200 relative group">
                        Beranda
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-200"></span>
                    </a>
                    <a href="/pesanan"
                        class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200 relative group">
                        Pesanan
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-200"></span>
                    </a>
                    <a href="/profile"
                        class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200 relative group">
                        Profile
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-200"></span>
                    </a>
                    <form method="POST" action="/logout">
                        @csrf
                        @method('POST')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 transform hover:scale-105">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/login"
                        class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200">Login/Register</a>
                </div>
            @endguest

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 hover:text-indigo-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="md:hidden hidden pb-4">
            <div class="flex flex-col space-y-3 mt-2">
                @auth
                    <a href="/"
                        class="text-gray-700 hover:text-indigo-600 font-medium py-2 px-3 rounded-lg hover:bg-gray-50 transition-all duration-200">Beranda</a>
                    <a href="/pesanan"
                        class="text-gray-700 hover:text-indigo-600 font-medium py-2 px-3 rounded-lg hover:bg-gray-50 transition-all duration-200">Pesanan</a>
                    <a href="/profile"
                        class="text-gray-700 hover:text-indigo-600 font-medium py-2 px-3 rounded-lg hover:bg-gray-50 transition-all duration-200">Profile</a>
                    <form method="POST" action="/logout">
                        @csrf
                        @method('POST')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 mx-3 rounded-lg font-medium transition-all duration-200 text-center">
                            Logout
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="/login"
                        class="text-gray-700 hover:text-indigo-600 font-medium py-2 px-3 rounded-lg hover:bg-gray-50 transition-all duration-200">Login/Register</a>
                @endguest
            </div>
        </div>
    </div>
</nav>

<!-- Spacer for fixed nav -->
<div class="h-20"></div>

<!-- Script for toggling mobile menu -->
<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
