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
                <div class="p-3">
                    <h5 class="text-center mb-4">Menu Antrian</h5>
                    <a href="{{ route('admin.index') }}" class="sidebar-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                        Daftar Antrian
                    </a>
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
    </script>
    @stack('scripts')
</body>
</html>
