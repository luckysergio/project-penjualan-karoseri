@extends('layouts-admin.app')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        @if (Auth::user()->role_id == 1)
            {{-- Order Masuk --}}
            <a href="{{ url('/order') }}"
                class="flex flex-col items-center justify-center text-white bg-gradient-to-r from-blue-500 to-blue-700 p-6 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition transform text-center">
                <i class="fas fa-shopping-cart fa-3x mb-4"></i>
                <h3 class="text-sm font-semibold tracking-wide uppercase opacity-80">Order Masuk</h3>
                <p id="order-count" class="text-4xl font-bold mt-2">{{ $orderMasuk }}</p>
                <span class="text-xs mt-1 opacity-70">Hari ini</span>
            </a>

            <a href="{{ url('/proses') }}"
                class="flex flex-col items-center justify-center text-white bg-gradient-to-r from-purple-500 to-purple-700 p-6 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition transform text-center">
                <i class="fas fa-spinner fa-3x mb-4 animate-spin"></i>
                <h3 class="text-sm font-semibold tracking-wide uppercase opacity-80">Order Berjalan</h3>
                <p id="order-berjalan-count" class="text-4xl font-bold mt-2">{{ $orderBerjalan }}</p>
                <span class="text-xs mt-1 opacity-70">Proses</span>
            </a>

            {{-- Order Selesai --}}
            <a href="{{ url('/selesai') }}"
                class="flex flex-col items-center justify-center text-white bg-gradient-to-r from-indigo-500 to-indigo-700 p-6 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition transform text-center">
                <i class="fas fa-check-circle fa-3x mb-4"></i>
                <h3 class="text-sm font-semibold tracking-wide uppercase opacity-80">Order Selesai</h3>
                <p id="order-selesai-count" class="text-4xl font-bold mt-2">{{ $orderSelesai }}</p>
                <span class="text-xs mt-1 opacity-70">Selesai Dikerjakan</span>
            </a>

            {{-- Pengiriman Aktif --}}
            <a href="{{ url('/pengirimans-admin') }}"
                class="flex flex-col items-center justify-center text-white bg-gradient-to-r from-green-500 to-green-700 p-6 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition transform text-center">
                <i class="fas fa-truck fa-3x mb-4"></i>
                <h3 class="text-sm font-semibold tracking-wide uppercase opacity-80">Pengiriman Aktif</h3>
                <p id="pengiriman-count" class="text-4xl font-bold mt-2">{{ $pengirimanAktif }}</p>
                <span class="text-xs mt-1 opacity-70">Persiapan & Dikirim</span>
            </a>
        @endif

        @if (Auth::user()->role_id == 2)
            {{-- Order Saya --}}
            <a href="{{ url('/order-sales') }}"
                class="flex flex-col items-center justify-center text-white bg-gradient-to-r from-indigo-500 to-indigo-700 p-6 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition transform text-center">
                <i class="fas fa-user-check fa-3x mb-4"></i>
                <h3 class="text-sm font-semibold tracking-wide uppercase opacity-80">Order Saya</h3>
                <p id="order-saya-count" class="text-4xl font-bold mt-2">{{ $orderSaya }}</p>
                <span class="text-xs mt-1 opacity-70">Semua Order</span>
            </a>

            {{-- Pengiriman Saya --}}
            <a href="{{ url('/pengiriman') }}"
                class="flex flex-col items-center justify-center text-white bg-gradient-to-r from-purple-500 to-purple-700 p-6 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition transform text-center">
                <i class="fas fa-shipping-fast fa-3x mb-4"></i>
                <h3 class="text-sm font-semibold tracking-wide uppercase opacity-80">Pengiriman Saya</h3>
                <p id="pengiriman-saya-count" class="text-4xl font-bold mt-2">{{ $pengirimanSaya }}</p>
                <span class="text-xs mt-1 opacity-70">Persiapan & Dikirim</span>
            </a>

            {{-- Order Selesai Saya --}}
            <a href="{{ url('/sales-selesai') }}"
                class="flex flex-col items-center justify-center text-white bg-gradient-to-r from-emerald-500 to-emerald-700 p-6 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition transform text-center">
                <i class="fas fa-check-circle fa-3x mb-4"></i>
                <h3 class="text-sm font-semibold tracking-wide uppercase opacity-80">Order Selesai</h3>
                <p id="order-selesai-saya-count" class="text-4xl font-bold mt-2">{{ $orderSelesaiSaya }}</p>
                <span class="text-xs mt-1 opacity-70">Laporan Selesai</span>
            </a>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        Pusher.logToConsole = true;

        const PUSHER_APP_KEY = "{{ env('PUSHER_APP_KEY') }}";
        const PUSHER_APP_CLUSTER = "{{ env('PUSHER_APP_CLUSTER') }}";

        var pusher = new Pusher(PUSHER_APP_KEY, {
            cluster: PUSHER_APP_CLUSTER,
            forceTLS: true
        });

        function loadDashboardData() {
            fetch('/api/dashboard-data')
                .then(res => res.json())
                .then(data => {
                    if (document.getElementById('order-count')) {
                        document.getElementById('order-count').innerText = data.orderMasuk;
                    }
                    if (document.getElementById('pengiriman-count')) {
                        document.getElementById('pengiriman-count').innerText = data.pengirimanAktif;
                    }
                    if (document.getElementById('order-saya-count')) {
                        document.getElementById('order-saya-count').innerText = data.orderSaya;
                    }
                    if (document.getElementById('pengiriman-saya-count')) {
                        document.getElementById('pengiriman-saya-count').innerText = data.pengirimanSaya;
                    }
                });
        }

        loadDashboardData();
        var userId = {{ Auth::user()->id }};
        var notifChannel = pusher.subscribe('notification-channel.' + userId);

        notifChannel.bind('App\\Events\\OrderNotification', function(data) {
            console.log('Notif:', data.message);
            toastr.options = {
                "positionClass": "toast-bottom-right",
                "timeOut": "4000"
            };
            toastr.info(data.message);
            loadDashboardData();
        });

        @if (Auth::user()->role_id == 1)
            @if (Auth::user()->role_id == 1)
                var dashboardChannel = pusher.subscribe('dashboard-channel');

                dashboardChannel.bind('App\\Events\\DashboardUpdated', function(data) {
                    console.log('DashboardUpdated:', data);

                    if (document.getElementById('order-count')) {
                        document.getElementById('order-count').innerText = data.orderMasuk;
                    }
                    if (document.getElementById('pengiriman-count')) {
                        document.getElementById('pengiriman-count').innerText = data.pengirimanAktif;
                    }
                    if (document.getElementById('order-berjalan-count')) {
                        document.getElementById('order-berjalan-count').innerText = data.orderBerjalan;
                    }
                    if (document.getElementById('order-selesai-count')) {
                        document.getElementById('order-selesai-count').innerText = data.orderSelesai;
                    }
                });
            @endif
        @endif

        @if (Auth::user()->role_id == 2)
            var salesChannel = pusher.subscribe('sales-dashboard-channel.' + {{ Auth::user()->karyawan->id }});

            salesChannel.bind('App\\Events\\SalesDashboardUpdated', function(data) {
                console.log('SalesDashboardUpdated:', data);
                if (document.getElementById('order-saya-count')) {
                    document.getElementById('order-saya-count').innerText = data.orderSaya;
                }
                if (document.getElementById('pengiriman-saya-count')) {
                    document.getElementById('pengiriman-saya-count').innerText = data.pengirimanSaya;
                }
                if (document.getElementById('order-selesai-saya-count')) {
                    document.getElementById('order-selesai-saya-count').innerText = data.orderSelesaiSaya;
                }
            });
        @endif
    </script>
@endpush
