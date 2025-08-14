@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <img src="{{ asset('ImageHome/logoptun-removebg-preview.png') }}" alt="PTUN Logo" style="width: 45px; margin-right: 15px;">
            <h1 class="h3 mb-0" style="color: var(--ptun-primary)">Daftar Antrian</h1>
        </div>
        <div class="d-flex align-items-center bg-light px-3 py-2 rounded-pill shadow-sm">
            <i class="fas fa-clock me-2" style="color: var(--ptun-primary)"></i>
            <span class="current-time fw-bold" style="color: var(--ptun-primary)"></span>
        </div>
    </div>

    @if(session('success'))
<<<<<<< HEAD
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Antrian Hari Ini</h5>
                    <h2 class="mb-0">{{ $tickets->count() }}</h2>
=======
        <div class="alert alert-success alert-dismissible fade show" 
             style="background-color: #d8f3dc; color: var(--ptun-primary); border-color: #b7e4c7;" 
             role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="stats-card total-card">
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-info">
                    <h5>Total Antrian</h5>
                    <h3>{{ $tickets->count() }}</h3>
                </div>
                <div class="stats-progress">
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                    </div>
>>>>>>> 764074117e984bc3eb02604f3bcb6e7fff7ec0df
                </div>
            </div>
        </div>
        <div class="col-md-3">
<<<<<<< HEAD
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Menunggu</h5>
                    <h2 class="mb-0">{{ $tickets->where('status', 'waiting')->count() }}</h2>
=======
            <div class="stats-card waiting-card">
                <div class="stats-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-info">
                    <h5>Menunggu</h5>
                    <h3>{{ $tickets->where('status', 'waiting')->count() }}</h3>
                </div>
                <div class="stats-progress">
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width: {{ ($tickets->where('status', 'waiting')->count() / max(1, $tickets->count())) * 100 }}%"></div>
                    </div>
>>>>>>> 764074117e984bc3eb02604f3bcb6e7fff7ec0df
                </div>
            </div>
        </div>
        <div class="col-md-3">
<<<<<<< HEAD
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Sedang Dipanggil</h5>
                    <h2 class="mb-0">{{ $tickets->where('status', 'called')->count() }}</h2>
=======
            <div class="stats-card called-card">
                <div class="stats-icon">
                    <i class="fas fa-volume-up"></i>
                </div>
                <div class="stats-info">
                    <h5>Sedang Dipanggil</h5>
                    <h3>{{ $tickets->where('status', 'called')->count() }}</h3>
                </div>
                <div class="stats-progress">
                    <div class="progress">
                        <div class="progress-bar bg-info" style="width: {{ ($tickets->where('status', 'called')->count() / max(1, $tickets->count())) * 100 }}%"></div>
                    </div>
>>>>>>> 764074117e984bc3eb02604f3bcb6e7fff7ec0df
                </div>
            </div>
        </div>
        <div class="col-md-3">
<<<<<<< HEAD
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Selesai</h5>
                    <h2 class="mb-0">{{ $tickets->where('status', 'done')->count() }}</h2>
=======
            <div class="stats-card done-card">
                <div class="stats-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-info">
                    <h5>Selesai</h5>
                    <h3>{{ $tickets->where('status', 'done')->count() }}</h3>
                </div>
                <div class="stats-progress">
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: {{ ($tickets->where('status', 'done')->count() / max(1, $tickets->count())) * 100 }}%"></div>
                    </div>
>>>>>>> 764074117e984bc3eb02604f3bcb6e7fff7ec0df
                </div>
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <div style="margin-bottom: 10px;">
    <label for="voiceSelect">Pilih Suara:</label>
    <select id="voiceSelect"></select>
</div>


    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Antrian Hari Ini</h5>
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="window.location.reload()">
                    <i class="fas fa-sync"></i> Refresh Data
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No. Antrian</th>
                            <th>Status</th>
                            <th>Waktu Dibuat</th>
                            <th>Aksi</th>
=======
    <div class="card shadow">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0" style="color: var(--ptun-primary); font-weight: 600;">
                <i class="fas fa-clipboard-list me-2"></i>
                Daftar Antrian Hari Ini
            </h5>
            <button type="button" class="btn btn-light btn-sm shadow-sm" 
                    style="background-color: #f8faf8; border: 1px solid #d8f3dc;"
                    onmouseover="this.style.backgroundColor='var(--ptun-primary)'; this.style.color='white';"
                    onmouseout="this.style.backgroundColor='#f8faf8'; this.style.color='inherit';"
                    onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-1"></i> Refresh Data
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No. Antrian</th>
                            <th>Status</th>
                            <th>Waktu Dibuat</th>
                            <th class="text-center">Aksi</th>
>>>>>>> 764074117e984bc3eb02604f3bcb6e7fff7ec0df
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
<<<<<<< HEAD
                            <td>{{ $ticket->display_number }}</td>
                            <td>
                                <span class="badge bg-{{ $ticket->status == 'waiting' ? 'warning' : ($ticket->status == 'called' ? 'primary' : 'success') }}">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td>{{ $ticket->created_at->format('d M Y H:i:s') }}</td>
                            <td>
                                <form action="{{ route('admin.updateStatus', $ticket) }}" method="POST" class="call-form d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <div class="btn-group" role="group">
                                        @if(request()->get('filter') === 'called')
                                            <button type="submit" name="status" value="done" class="btn btn-sm btn-success">Selesai</button>
                                        @else
                                            <button type="submit" name="status" value="called" class="btn btn-sm btn-info panggil-btn" data-number="{{ $ticket->display_number }}">Panggil</button>
                                            <button type="submit" name="status" value="done" class="btn btn-sm btn-secondary">Lewati</button>
                                        @endif
=======
                            <td class="text-center">
                                <span class="fw-bold fs-5">{{ $ticket->display_number }}</span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $ticket->status }}">
                                    <i class="fas fa-{{ $ticket->status == 'waiting' ? 'clock' : ($ticket->status == 'called' ? 'volume-up' : 'check-circle') }} me-1"></i>
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-dark">{{ $ticket->created_at->format('d M Y') }}</span>
                                    <small class="text-muted">{{ $ticket->created_at->format('H:i:s') }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.updateStatus', $ticket) }}" method="POST" class="d-inline status-action-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $ticket->status }}" class="status-input">
                                    <div class="status-button-group" role="group" aria-label="Status actions">
                                        <button type="button" 
                                                class="status-btn waiting-btn {{ $ticket->status == 'waiting' ? 'active' : '' }}"
                                                data-status="waiting"
                                                onclick="updateStatus(this)">
                                            <i class="fas fa-clock"></i>
                                            <span>Waiting</span>
                                        </button>
                                        <button type="button" 
                                                class="status-btn called-btn {{ $ticket->status == 'called' ? 'active' : '' }}"
                                                data-status="called"
                                                onclick="updateStatus(this)">
                                            <i class="fas fa-volume-up"></i>
                                            <span>Called</span>
                                        </button>
                                        <button type="button" 
                                                class="status-btn done-btn {{ $ticket->status == 'done' ? 'active' : '' }}"
                                                data-status="done"
                                                onclick="updateStatus(this)">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Done</span>
                                        </button>
>>>>>>> 764074117e984bc3eb02604f3bcb6e7fff7ec0df
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.panggil-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                let nomor = this.getAttribute('data-number');
                
                // Panggil file call-tts.js dengan parameter nomor
                fetch(`/call-tts?number=${encodeURIComponent(nomor)}`)
                    .then(res => res.blob())
                    .then(blob => {
                        let audioURL = URL.createObjectURL(blob);
                        let audio = new Audio(audioURL);
                        audio.play();
                        audio.onended = () => {
                            this.closest('form').submit();
                        };
                    })
                    .catch(err => {
                        console.error("Gagal memutar audio:", err);
                        this.closest('form').submit(); // Tetap submit jika audio gagal
                    });
            });
        });
    });
=======
    <style>
        /* Stats Card Styles */
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            transition: transform 0.2s;
            position: relative;
            overflow: hidden;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            opacity: 0.8;
        }

        /* Warna tema PTUN */
        :root {
            --ptun-primary: #1a4731;
            --ptun-secondary: #2d6a4f;
            --ptun-success: #2d6a4f;
            --ptun-warning: #d4a373;
            --ptun-info: #40916c;
            --ptun-danger: #bc4749;
        }

        .text-primary {
            color: var(--ptun-primary) !important;
        }

        .total-card .stats-icon { color: var(--ptun-primary); }
        .waiting-card .stats-icon { color: var(--ptun-warning); }
        .called-card .stats-icon { color: var(--ptun-info); }
        .done-card .stats-icon { color: var(--ptun-success); }

        .stats-info h5 {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }

        .stats-info h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            color: var(--ptun-primary);
        }

        .stats-progress {
            margin-top: 15px;
        }

        .progress {
            height: 0.5rem;
            border-radius: 0.25rem;
            background-color: rgba(0,0,0,0.05);
        }

        .progress-bar.bg-primary { background-color: var(--ptun-primary) !important; }
        .progress-bar.bg-warning { background-color: var(--ptun-warning) !important; }
        .progress-bar.bg-info { background-color: var(--ptun-info) !important; }
        .progress-bar.bg-success { background-color: var(--ptun-success) !important; }

        /* Status Badge Styles */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-waiting {
            background-color: #f8e4d1;
            color: #8b5e34;
            border: 1px solid #d4a373;
        }

        .status-called {
            background-color: #d8f3dc;
            color: #2d6a4f;
            border: 1px solid #40916c;
        }

        .status-done {
            background-color: #b7e4c7;
            color: #1a4731;
            border: 1px solid #2d6a4f;
        }

        /* Table Styles */
        .table {
            font-size: 0.9rem;
        }

        .status-select {
            width: auto;
            font-size: 0.85rem;
            padding: 0.25rem 2rem 0.25rem 0.5rem;
            border-radius: 20px;
            border: 1px solid #d8f3dc;
            background-color: #f8faf8;
        }

        .status-select:focus {
            box-shadow: none;
            border-color: var(--ptun-primary);
        }

        /* Card Shadow */
        .shadow {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(45, 106, 79, 0.15) !important;
        }

        /* Refresh Button Hover Effect */
        .btn-light:hover {
            background-color: var(--ptun-primary);
            color: white;
        }

        /* Card Header */
        .card-header {
            border-bottom: 2px solid #e9f5eb !important;
        }

        /* Table Header */
        .table-light {
            background-color: #f8faf8 !important;
        }

        .table-hover tbody tr:hover {
            background-color: #f7f9f7 !important;
        }

        /* Status Button Styles */
        .status-button-group {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .status-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 30px;
            border: 2px solid transparent;
            background-color: #f8f9fa;
            color: #666;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .status-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                120deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transition: 0.5s;
        }

        .status-btn:hover::before {
            left: 100%;
        }

        .status-btn i {
            font-size: 1rem;
        }

        /* Waiting Button */
        .waiting-btn {
            border-color: var(--ptun-warning);
            color: #8b5e34;
        }
        .waiting-btn:hover, .waiting-btn.active {
            background-color: var(--ptun-warning);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 163, 115, 0.3);
        }

        /* Called Button */
        .called-btn {
            border-color: var(--ptun-info);
            color: var(--ptun-info);
        }
        .called-btn:hover, .called-btn.active {
            background-color: var(--ptun-info);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(64, 145, 108, 0.3);
        }

        /* Done Button */
        .done-btn {
            border-color: var(--ptun-success);
            color: var(--ptun-success);
        }
        .done-btn:hover, .done-btn.active {
            background-color: var(--ptun-success);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 106, 79, 0.3);
        }

        /* Active State Pulse Animation */
        .status-btn.active {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(45, 106, 79, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(45, 106, 79, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(45, 106, 79, 0);
            }
        }

        /* Status Transition Animation */
        .status-btn {
            animation: statusChange 0.3s ease-out;
        }

        @keyframes statusChange {
            0% {
                transform: scale(0.9);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    <script>
        // Update current time
        function updateCurrentTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            };
            document.querySelector('.current-time').textContent = now.toLocaleDateString('id-ID', options);
        }

        // Update time every second
        updateCurrentTime();
        setInterval(updateCurrentTime, 1000);

        // Function to handle status updates
        function updateStatus(button) {
            const form = button.closest('form');
            const statusInput = form.querySelector('.status-input');
            const newStatus = button.dataset.status;
            const row = button.closest('tr');
            
            // Update hidden input value
            statusInput.value = newStatus;

            // Remove active class from all buttons in this group
            button.parentElement.querySelectorAll('.status-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to clicked button
            button.classList.add('active');

            // Add transition effect to the row
            row.style.backgroundColor = '#f8f9fc';
            setTimeout(() => {
                row.style.backgroundColor = '';
            }, 1000);

            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            
            // Submit the form
            form.submit();
        }

        // Initialize tooltips
        document.querySelectorAll('.status-btn').forEach(button => {
            button.addEventListener('mouseover', function() {
                const status = this.dataset.status;
                let message = '';
                
                switch(status) {
                    case 'waiting':
                        message = 'Set status to Waiting';
                        break;
                    case 'called':
                        message = 'Set status to Called';
                        break;
                    case 'done':
                        message = 'Set status to Done';
                        break;
                }
                
                this.setAttribute('title', message);
            });
        });

        // Add sound effect for status changes
        const statusChangeSound = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodHRr3ZCKj+a2fLToWI7OIHJ6/LDkmk8LXfH7vi8kGI6KI/k/easclIwSpPt/cqKYkcviN/5xFxAR1PP8vO1kXBHGJHq+L1oUDVjtef0sIxwTRqe4O+0cl87Xrjj6a+GdVIXp+PqqYB0TxC26OypfGNnK8Tj6qZ8ZlBPweTqpHxgTSnH5OyjfGVQSMrm7KN8aFFEyebso31jUEPG5eujfGVRQ8Xk66N9Y1FDxOTro31jUULE5OujfWNRQ8Tj66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTrZGF0YWoGAAA=');
        statusChangeSound.volume = 0.3;

        document.querySelectorAll('.status-btn').forEach(button => {
            button.addEventListener('click', () => {
                if (!button.classList.contains('active')) {
                    statusChangeSound.play();
                }
            });
        });
>>>>>>> 764074117e984bc3eb02604f3bcb6e7fff7ec0df
    </script>
@endsection
