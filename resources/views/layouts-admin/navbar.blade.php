<nav class="navbar navbar-expand navbar-light bg-grey topbar mb-4 static-top">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter d-none" id="alert-count">0</span>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Alerts Center</h6>
                <div id="alert-list">
                    <a class="dropdown-item text-center small text-gray-500" href="#">Tidak ada notifikasi</a>
                </div>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Info -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                <i class="fas fa-user-circle text-3xl text-gray-700"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = false;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });

        var userId = {{ auth()->user()->id }};
        var channel = pusher.subscribe('notification-channel.' + userId);

        function formatDateIndo(dateStr) {
            let d = new Date(dateStr);
            let day = String(d.getDate()).padStart(2, '0');
            let month = String(d.getMonth() + 1).padStart(2, '0');
            let year = d.getFullYear();
            let hours = String(d.getHours()).padStart(2, '0');
            let minutes = String(d.getMinutes()).padStart(2, '0');
            let seconds = String(d.getSeconds()).padStart(2, '0');
            return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
        }

        channel.bind('App\\Events\\OrderNotification', function(data) {
            console.log("Pesan Masuk: ", data);

            let list = document.getElementById('alert-list');

            if (list.children.length === 1 && list.children[0].textContent.includes("Tidak ada notifikasi")) {
                list.innerHTML = '';
            }

            let linkOrder = '#';

            const item = document.createElement('a');
            item.classList = 'dropdown-item d-flex align-items-center';
            item.href = linkOrder;
            item.innerHTML = `
            <div class="mr-3">
                <div class="icon-circle bg-primary">
                    <i class="fas fa-file-alt text-white"></i>
                </div>
            </div>
            <div>
                <div class="small text-gray-500">${formatDateIndo(data.timestamp)}</div>
                <span class="font-weight-bold">${data.message} ${data.order_id ? '(' + data.order_id + ')' : ''}</span>
            </div>
        `;

            list.prepend(item);

            let countBadge = document.getElementById('alert-count');
            let currentCount = parseInt(countBadge.textContent) || 0;
            let newCount = currentCount + 1;
            countBadge.textContent = newCount;
            countBadge.classList.remove('d-none');
        });

        document.getElementById('alertsDropdown').addEventListener('click', function() {
            let countBadge = document.getElementById('alert-count');
            countBadge.textContent = '0';
            countBadge.classList.add('d-none');
        });
    </script>
</nav>
