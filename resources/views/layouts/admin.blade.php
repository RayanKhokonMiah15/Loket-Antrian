<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - PTUN Bandung</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Admin CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <!-- Call TTS Script -->
    <script src="{{ asset('js/call-tts.js') }}"></script>

    <!-- Notification Sound -->
    <audio id="notificationSound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 bg-white sidebar">
                <div class="p-3 d-flex flex-column" style="height: 100vh;">
                    <!-- Logo dan Nama Aplikasi -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('Image/logoptun-removebg-preview.png') }}" alt="PTUN Logo" class="sidebar-logo mb-2" style="width: 60px;">
                        <h5 class="sidebar-title">Menu Antrian</h5>
                    </div>

                    <!-- Menu Links -->
                    <div class="flex-grow-1">
                        <div class="sidebar-menu">
                            <a href="{{ route('admin.index') }}" class="sidebar-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                            
                            <!-- Filter Section -->
                            <div class="filter-section mt-3">
                                <div class="filter-header mb-2 px-3">
                                    <span class="filter-title">
                                        <i class="fas fa-filter me-2"></i>Filter Loket
                                    </span>
                                </div>
                                <div class="filter-container px-2">
                                    <button class="loket-filter d-flex align-items-center justify-content-between w-100 active" id="allLoketToggle" data-loket="all">
                                        <div class="d-flex align-items-center">
                                            <div class="filter-icon">
                                                <i class="fas fa-list-ul"></i>
                                            </div>
                                            <div class="filter-text">Semua Loket</div>
                                        </div>
                                        <i class="fas fa-chevron-down toggle-icon"></i>
                                    </button>
                                    <div id="loketOptions" class="collapse mt-2">
                                        <button class="loket-filter d-flex align-items-center" data-loket="A">
                                            <div class="filter-icon">
                                                <i class="fas fa-file-signature"></i>
                                            </div>
                                            <div class="filter-text">Loket A</div>
                                        </button>
                                        <button class="loket-filter d-flex align-items-center" data-loket="B">
                                            <div class="filter-icon">
                                                <i class="fas fa-comments"></i>
                                            </div>
                                            <div class="filter-text">Loket B</div>
                                        </button>
                                        <button class="loket-filter d-flex align-items-center" data-loket="C">
                                            <div class="filter-icon">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div class="filter-text">Loket C</div>
                                        </button>
                                        <button class="loket-filter d-flex align-items-center" data-loket="D">
                                            <div class="filter-icon">
                                                <i class="fas fa-info-circle"></i>
                                            </div>
                                            <div class="filter-text">Loket D</div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-auto">
                <div class="header">
                    <button class="btn d-lg-none text-success" id="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let lastCount = {{ $tickets->count() ?? 0 }};
        
        // Setup collapsible filter with animation
        const allLoketToggle = document.getElementById('allLoketToggle');
        const loketOptions = document.getElementById('loketOptions');
        
        // Add ripple effect function
        function createRipple(event) {
            const button = event.currentTarget;
            const ripple = document.createElement('span');
            
            const diameter = Math.max(button.clientWidth, button.clientHeight);
            const radius = diameter / 2;
            
            const rect = button.getBoundingClientRect();
            
            ripple.style.width = ripple.style.height = `${diameter}px`;
            ripple.style.left = `${event.clientX - rect.left - radius}px`;
            ripple.style.top = `${event.clientY - rect.top - radius}px`;
            ripple.className = 'ripple';
            
            // Remove existing ripples
            const existingRipple = button.getElementsByClassName('ripple')[0];
            if (existingRipple) {
                existingRipple.remove();
            }
            
            button.appendChild(ripple);
            
            // Remove ripple after animation
            setTimeout(() => {
                ripple.remove();
            }, 600);
        }
        
        allLoketToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // Add ripple effect
            createRipple(e);
            
            // Toggle the collapse state with animation
            this.setAttribute('aria-expanded', !isExpanded);
            
            if (!isExpanded) {
                // Expanding animation
                loketOptions.style.maxHeight = '0px';
                loketOptions.classList.add('show');
                setTimeout(() => {
                    loketOptions.style.maxHeight = loketOptions.scrollHeight + 'px';
                }, 10);
            } else {
                // Collapsing animation
                loketOptions.style.maxHeight = loketOptions.scrollHeight + 'px';
                setTimeout(() => {
                    loketOptions.style.maxHeight = '0px';
                }, 10);
                setTimeout(() => {
                    loketOptions.classList.remove('show');
                }, 300);
            }
            
            // If this is a filter click (not just expand/collapse)
            if (!e.target.classList.contains('toggle-icon')) {
                filterByLoket('all');
                document.querySelectorAll('.loket-filter').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            }
        });

        // Event listener untuk filter buttons dalam loketOptions
        document.querySelectorAll('#loketOptions .loket-filter').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Hapus kelas active dari semua buttons
                document.querySelectorAll('.loket-filter').forEach(b => b.classList.remove('active'));
                
                // Tambah kelas active ke button yang diklik
                this.classList.add('active');
                
                // Terapkan filter
                const loket = this.dataset.loket;
                filterByLoket(loket);
            });
        });

        function filterByLoket(loket) {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const ticketNumber = row.querySelector('td:first-child').textContent.trim();
                if (loket === 'all') {
                    row.style.display = '';
                } else {
                    // Extract loket type from ticket number (A1, B1, C1, etc.)
                    const ticketLoket = ticketNumber.charAt(0);
                    row.style.display = (ticketLoket === loket) ? '' : 'none';
                }
            });
            
            // Update statistik setelah filter
            updateStats();
        }
        
        function updateStats() {
            const visibleRows = document.querySelectorAll('tbody tr:not([style*="display: none"])');
            const total = visibleRows.length;
            const waiting = Array.from(visibleRows).filter(row => 
                row.querySelector('.status-badge').textContent.toLowerCase().includes('waiting')).length;
            const called = Array.from(visibleRows).filter(row => 
                row.querySelector('.status-badge').textContent.toLowerCase().includes('called')).length;
            const done = Array.from(visibleRows).filter(row => 
                row.querySelector('.status-badge').textContent.toLowerCase().includes('done')).length;
            
            // Update statistik cards
            document.querySelector('.total-card .stats-info h3').textContent = total;
            document.querySelector('.waiting-card .stats-info h3').textContent = waiting;
            document.querySelector('.called-card .stats-info h3').textContent = called;
            document.querySelector('.done-card .stats-info h3').textContent = done;
        }

        function refreshTable() {
            $.ajax({
                url: '{{ route("admin.index") }}',
                success: function(response) {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(response, 'text/html');
                    const newCount = doc.querySelectorAll('tbody tr').length;
                    
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
                    flash.innerHTML = '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
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

</body>
</html>
