<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'Home') | PT. Harapan Duta Pertiwi</title>
    <meta name="description" content="@yield('description', 'PT. Harapan Duta Pertiwi - Solusi terpercaya untuk distribusi dan logistik di Indonesia')">
    <meta name="keywords" content="@yield('keywords', 'distribusi, logistik, pengiriman, Indonesia')">
    <meta name="author" content="PT. Harapan Duta Pertiwi">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="@yield('title', 'Home') | PT. Harapan Duta Pertiwi">
    <meta property="og:description" content="@yield('description', 'PT. Harapan Duta Pertiwi - Solusi terpercaya untuk distribusi dan logistik di Indonesia')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->url() }}">
    <meta property="twitter:title" content="@yield('title', 'Home') | PT. Harapan Duta Pertiwi">
    <meta property="twitter:description" content="@yield('description', 'PT. Harapan Duta Pertiwi - Solusi terpercaya untuk distribusi dan logistik di Indonesia')">
    <meta property="twitter:image" content="@yield('og_image', asset('images/og-image.jpg'))">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.min.css" rel="stylesheet" />

    <!-- Styles -->
    @vite('resources/css/app.css')

    <!-- Additional CSS -->
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #6366f1, #8b5cf6);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #4f46e5, #7c3aed);
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Loading animation for images */
        .img-loading {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Focus styles for better accessibility */
        .focus-visible:focus {
            outline: 2px solid #6366f1;
            outline-offset: 2px;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-900 font-['Inter'] antialiased selection:bg-indigo-100 selection:text-indigo-900">

    <!-- Skip to main content for accessibility -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-indigo-600 text-white px-4 py-2 rounded-lg z-50">
        Skip to main content
    </a>

    <!-- Page Loading Indicator -->
    <div id="page-loader"
        class="fixed inset-0 bg-white z-50 flex items-center justify-center transition-opacity duration-300">
        <div class="flex flex-col items-center">
            <div class="w-12 h-12 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin mb-4"></div>
            <p class="text-gray-600 font-medium">Loading...</p>
        </div>
    </div>

    <!-- Navigation -->
    <header role="banner">
        @include('layouts.navbar')
    </header>

    <!-- Main Content -->
    <main id="main-content" class="min-h-screen" role="main">
        @yield('contentweb')
    </main>

    <!-- Footer -->
    <footer role="contentinfo">
        @include('layouts.footer')
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top"
        class="fixed bottom-6 right-6 bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-3 rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300 opacity-0 pointer-events-none z-40"
        aria-label="Back to top">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <!-- Scripts -->
    @vite('resources/js/app.js')

    <!-- Global JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hide page loader
            const pageLoader = document.getElementById('page-loader');
            if (pageLoader) {
                setTimeout(() => {
                    pageLoader.style.opacity = '0';
                    setTimeout(() => {
                        pageLoader.style.display = 'none';
                    }, 300);
                }, 500);
            }

            // Back to top button functionality
            const backToTopButton = document.getElementById('back-to-top');

            function toggleBackToTop() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.remove('opacity-0', 'pointer-events-none');
                    backToTopButton.classList.add('opacity-100');
                } else {
                    backToTopButton.classList.add('opacity-0', 'pointer-events-none');
                    backToTopButton.classList.remove('opacity-100');
                }
            }

            window.addEventListener('scroll', toggleBackToTop);

            backToTopButton.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Lazy loading for images
            const images = document.querySelectorAll('img[data-src]');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('img-loading');
                        imageObserver.unobserve(img);
                    }
                });
            });

            images.forEach(img => {
                img.classList.add('img-loading');
                imageObserver.observe(img);
            });

            // Add smooth scroll to anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Enhanced focus management for accessibility
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    document.body.classList.add('using-keyboard');
                }
            });

            document.addEventListener('mousedown', function() {
                document.body.classList.remove('using-keyboard');
            });
        });

        // Global error handling
        window.addEventListener('error', function(e) {
            console.error('Global error:', e.error);
            // You can add error reporting service here
        });

        // Performance monitoring
        window.addEventListener('load', function() {
            if ('performance' in window) {
                const perfData = performance.timing;
                const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
                console.log('Page load time:', pageLoadTime + 'ms');
            }
        });
    </script>

    @stack('scripts')

    @if (session('lengkapi_data'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Lengkapi Data!',
                text: 'Silakan lengkapi data profil Anda terlebih dahulu.',
                confirmButtonColor: '#6366F1'
            });
        </script>
    @endif

    <!-- Service Worker Registration (optional) -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('SW registered: ', registration);
                    })
                    .catch(function(registrationError) {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }
    </script>
</body>

</html>
