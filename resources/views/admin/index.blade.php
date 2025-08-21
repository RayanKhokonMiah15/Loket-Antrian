@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <img src="{{ asset('Image/logoptun-removebg-preview.png') }}" alt="PTUN Logo" style="width: 45px; margin-right: 15px;">
            <h1 class="h3 mb-0" style="color: var(--ptun-primary)">Daftar Antrian</h1>
        </div>
    </div>

    {{-- Notifikasi success dihilangkan sesuai permintaan --}}

    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <button type="button" class="stats-card total-card w-100 border-0 p-0" style="background:none;" onclick="showStatsModal('all')">
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
            </button>
        </div>
        <div class="col-md-3">
            <button type="button" class="stats-card waiting-card w-100 border-0 p-0" style="background:none;" onclick="showStatsModal('waiting')">
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
            </button>
        </div>
        <div class="col-md-3">
            <button type="button" class="stats-card called-card w-100 border-0 p-0" style="background:none;" onclick="showStatsModal('called')">
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
            </button>
        </div>
        <div class="col-md-3">
            <button type="button" class="stats-card done-card w-100 border-0 p-0" style="background:none;" onclick="showStatsModal('done')">
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
            </button>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0" style="color: var(--ptun-primary); font-weight: 600;">
                <i class="fas fa-clipboard-list me-2"></i>
                Daftar Antrian Hari Ini
            </h5>
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
                        @if($ticket->status !== 'done')
                        <tr>
                            <td class="text-center">
                                <span class="fw-bold fs-5 counter-{{ $ticket->counter_type }}">{{ $ticket->display_number }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="status-badge status-{{ $ticket->status }}">
                                        <i class="fas fa-{{ $ticket->status == 'waiting' ? 'clock' : ($ticket->status == 'called' ? 'volume-up' : 'check-circle') }} me-1"></i>
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                    <span class="counter-badge counter-{{ $ticket->counter_type }} ms-2">
                                        <i class="fas fa-{{ 
                                            $ticket->counter_type == 'A' ? 'file-signature' : 
                                            ($ticket->counter_type == 'B' ? 'comments' : 
                                            ($ticket->counter_type == 'C' ? 'file-alt' : 'info-circle')) 
                                        }} me-1"></i>
                                        Loket {{ $ticket->counter_type }}
                                    </span>
                                </div>
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
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- Modal Pop Up Statistik -->
<div class="modal fade" id="statsModal" tabindex="-1" aria-labelledby="statsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statsModalLabel">Data Antrian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="statsModalTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No. Antrian</th>
                                <th>Status</th>
                                <th>Waktu Dibuat</th>
                            </tr>
                        </thead>
                        <tbody id="statsModalTableBody">
                            @foreach($tickets as $ticket)
                            <tr data-status="{{ $ticket->status }}">
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let statsModalInstance = null;
let statsModalStatus = null;
let statsModalOpen = false;
function showStatsModal(status) {
    const modalEl = document.getElementById('statsModal');
    if (!statsModalInstance) {
        statsModalInstance = new bootstrap.Modal(modalEl, {backdrop: 'static', keyboard: false});
    }
    statsModalStatus = status;
    statsModalOpen = true;
    filterStatsModalRows();
    // Set judul modal
    let title = 'Data Antrian';
    if(status==='waiting') title = 'Data Menunggu';
    else if(status==='called') title = 'Data Sedang Dipanggil';
    else if(status==='done') title = 'Data Selesai';
    else title = 'Data Antrian';
    document.getElementById('statsModalLabel').textContent = title;
    statsModalInstance.show();
}
function filterStatsModalRows() {
    const rows = document.querySelectorAll('#statsModalTable tbody tr');
    rows.forEach(row => {
        if (statsModalStatus === 'all' || row.getAttribute('data-status') === statsModalStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection
