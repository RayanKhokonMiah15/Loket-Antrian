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
@endsection
