<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sistem Antrian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <audio id="notificationSound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 bg-white sidebar">
<<<<<<< HEAD
                <div class="p-3">
                    <h5 class="text-center mb-4">Menu Antrian</h5>
                    <a href="{{ route('admin.index') }}" class="sidebar-link {{ request()->routeIs('admin.index') && !request()->get('filter') ? 'active' : '' }}" style="background-color: #10b981; color: #fff;">
                        Daftar Antrian
                    </a>
                    <a href="{{ route('admin.index', ['filter' => 'called']) }}" class="sidebar-link {{ request()->get('filter') == 'called' ? 'active' : '' }}" style="background-color: #2563eb; color: #fff;">
                        Sedang Dipanggil
                    </a>
                    <a href="{{ route('admin.index', ['filter' => 'done']) }}" class="sidebar-link {{ request()->get('filter') == 'done' ? 'active' : '' }}" style="background-color: #64748b; color: #fff;">
                        Selesai
                    </a>
=======
                <div class="p-3 d-flex flex-column" style="height: 100vh;">
                    <!-- Logo dan Nama Aplikasi -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('ImageHome/logoptun-removebg-preview.png') }}" alt="PTUN Logo" class="sidebar-logo mb-2" style="width: 60px;">
                        <h5 class="sidebar-title">Menu Antrian</h5>
                    </div>

                    <!-- Menu Links -->
                    <div class="flex-grow-1">
                        <a href="{{ route('admin.index') }}" class="sidebar-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                            <i class="fas fa-list-ul me-2"></i> Daftar Antrian
                        </a>
                    </div>

                    <!-- Logout Section -->
                    <div class="mt-auto">
                        <div class="border-top my-3"></div>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="button" onclick="confirmLogout()" class="sidebar-link text-danger w-100 text-start logout-btn" style="border: none; background: none;">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Konfirmasi Logout -->
            <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center py-4">
                            <i class="fas fa-question-circle text-warning mb-3" style="font-size: 3rem;"></i>
                            <p class="mb-1">Apakah Anda yakin ingin keluar?</p>
                            <p class="text-muted small">Anda harus login kembali untuk mengakses panel admin.</p>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Batal
                            </button>
                            <button type="button" class="btn btn-danger" onclick="document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i> Ya, Logout
                            </button>
                        </div>
                    </div>
>>>>>>> 764074117e984bc3eb02604f3bcb6e7fff7ec0df
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-4 py-3">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let lastCount = {{ $tickets->count() }};

        function refreshTable() {
            $.ajax({
                url: '{{ route("admin.index") }}',
                success: function(response) {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(response, 'text/html');
                    const newCount = doc.querySelectorAll('tbody tr').length;
                    
                    // Jika ada tiket baru
                    if (newCount > lastCount) {
                        document.getElementById('notificationSound').play();
                        const flash = document.createElement('div');
                        flash.className = 'alert alert-success alert-dismissible fade show';
                        flash.innerHTML = 'Ada tiket baru! <button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                        document.querySelector('.container-fluid').prepend(flash);
                    }
                    
                    // Update konten
                    document.querySelector('.card').innerHTML = doc.querySelector('.card').innerHTML;
                    document.querySelector('.row.mb-4').innerHTML = doc.querySelector('.row.mb-4').innerHTML;
                    
                    lastCount = newCount;
                }
            });
        }
        
        // Refresh setiap 3 detik
        setInterval(refreshTable, 3000);

        // Fungsi untuk menampilkan modal konfirmasi logout
        function confirmLogout() {
            const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        }
    </script>
    <script src="{{ asset('js/call-tts.js') }}"></script>
    <script>
    // Simpan status terakhir setiap tiket
    let lastTicketStatus = {};
    function updateLastTicketStatus() {
        document.querySelectorAll('tbody tr').forEach(tr => {
            const number = tr.querySelector('td').innerText.trim();
            const status = tr.querySelector('span.badge').innerText.trim().toLowerCase();
            lastTicketStatus[number] = status;
        });
    }
    updateLastTicketStatus();

    function checkAndSpeakCalled() {
        document.querySelectorAll('tbody tr').forEach(tr => {
            const number = tr.querySelector('td').innerText.trim();
            const status = tr.querySelector('span.badge').innerText.trim().toLowerCase();
            if (status === 'called' && lastTicketStatus[number] !== 'called') {
                window.callQueueNumber(number);
            }
            lastTicketStatus[number] = status;
        });
    }

    // Patch refreshTable agar cek status setelah reload
    const origRefreshTable = window.refreshTable;
    window.refreshTable = function() {
        $.ajax({
            url: '{{ route("admin.index") }}',
            success: function(response) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(response, 'text/html');
                const newCount = doc.querySelectorAll('tbody tr').length;
                if (newCount > lastCount) {
                    document.getElementById('notificationSound').play();
                    const flash = document.createElement('div');
                    flash.className = 'alert alert-success alert-dismissible fade show';
                    flash.innerHTML = 'Ada tiket baru! <button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                    document.querySelector('.container-fluid').prepend(flash);
                }
                document.querySelector('.card').innerHTML = doc.querySelector('.card').innerHTML;
                document.querySelector('.row.mb-4').innerHTML = doc.querySelector('.row.mb-4').innerHTML;
                lastCount = newCount;
                checkAndSpeakCalled();
            }
        });
    };
    // Juga cek saat pertama load
    document.addEventListener('DOMContentLoaded', function() {
        checkAndSpeakCalled();
    });
    </script>
    @stack('scripts')

    <style>
        /* Style untuk modal logout */
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .modal .btn {
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .logout-btn {
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            transform: translateX(5px);
        }

        .sidebar-logo {
            transition: transform 0.3s ease;
        }

        .sidebar-logo:hover {
            transform: scale(1.1);
        }

        /* Animasi untuk modal */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: none;
        }

        /* Style untuk sidebar yang lebih menarik */
        .sidebar {
            background: linear-gradient(180deg, #1a4731 0%, #2d6a4f 100%);
        }

        .sidebar-title {
            color: white;
            font-weight: 600;
            margin-bottom: 0;
        }

        /* Garis pemisah yang lebih halus */
        .border-top {
            border-color: rgba(255,255,255,0.1) !important;
        }
    </style>
</body>
</html>
