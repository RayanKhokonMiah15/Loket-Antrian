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
                </div>
            </div>
        </div>
        <div class="col-md-3">
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
                </div>
            </div>
        </div>
        <div class="col-md-3">
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
                </div>
            </div>
        </div>
        <div class="col-md-3">
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
                </div>
            </div>
        </div>
    </div>

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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
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
                                <form action="{{ route('admin.updateStatus', $ticket) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm status-select" onchange="this.form.submit()">
                                        <option value="waiting" {{ $ticket->status == 'waiting' ? 'selected' : '' }}>Waiting</option>
                                        <option value="called" {{ $ticket->status == 'called' ? 'selected' : '' }}>Called</option>
                                        <option value="done" {{ $ticket->status == 'done' ? 'selected' : '' }}>Done</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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

        // Add animation to status changes
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                this.closest('tr').style.backgroundColor = '#f8f9fc';
                setTimeout(() => {
                    this.closest('tr').style.backgroundColor = '';
                }, 1000);
            });
        });
    </script>
@endsection
