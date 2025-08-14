@extends('layouts.admin')

@section('content')
    <h1 class="mb-4">Daftar Antrian</h1>

    @if(session('success'))
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
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Menunggu</h5>
                    <h2 class="mb-0">{{ $tickets->where('status', 'waiting')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Sedang Dipanggil</h5>
                    <h2 class="mb-0">{{ $tickets->where('status', 'called')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Selesai</h5>
                    <h2 class="mb-0">{{ $tickets->where('status', 'done')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
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
    </script>
@endsection
