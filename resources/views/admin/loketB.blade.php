@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Daftar Antrian Loket B</h2>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No. Antrian</th>
                            <th>Status</th>
                            <th>Waktu Dibuat</th>
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
@endsection
