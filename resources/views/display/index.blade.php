<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Antrian - PTUN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/display.css') }}" rel="stylesheet">   
</head>
<body>
    <div class="display-container">
        <div class="header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('Image/logoptun-removebg-preview.png') }}" alt="PTUN Logo" style="height: 60px; margin-right: 1rem;">
                <h1 class="mb-0">Sistem Antrian PTUN</h1>
            </div>
            <div class="digital-clock" id="clock"></div>
        </div>

        <div class="row">
            <!-- Current Number -->
            <div class="col-md-6">
                <div class="current-number">
                    <h2 class="mb-4">NOMOR ANTRIAN SAAT INI</h2>
                    @if($currentTicket)
                        <div class="number">{{ $currentTicket->number }}</div>
                        <div class="mt-3">
                            <i class="fas fa-volume-up"></i> Sedang Dipanggil
                        </div>
                    @else
                        <div class="number text-muted">---</div>
                    @endif
                </div>

                <!-- Recently Called -->
                <div class="recently-called">
                    <h4 class="mb-3"><i class="fas fa-history"></i> Terakhir Dipanggil</h4>
                    <div class="row">
                        @foreach($recentlyCalled as $ticket)
                            <div class="col-4 mb-2">
                                <div class="p-2 bg-success bg-opacity-25 rounded text-center">
                                    {{ $ticket->number }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Waiting List -->
            <div class="col-md-6">
                <div class="waiting-list">
                    <h3 class="mb-4">
                        <i class="fas fa-list"></i> ANTRIAN BERIKUTNYA
                    </h3>
                    @forelse($waitingTickets as $ticket)
                        <div class="waiting-number d-flex justify-content-between align-items-center">
                            <span>{{ $ticket->number }}</span>
                            <small class="text-muted">{{ $ticket->created_at->format('H:i') }}</small>
                        </div>
                    @empty
                        <div class="text-center text-muted">
                            <i class="fas fa-check-circle fa-3x mb-3"></i>
                            <p>Tidak ada antrian menunggu</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Stats Footer -->
        <div class="stats-container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-box">
                        <i class="fas fa-ticket-alt mb-2"></i>
                        <h5>Total Hari Ini</h5>
                        <h3>{{ $stats['total'] }}</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <i class="fas fa-clock mb-2"></i>
                        <h5>Menunggu</h5>
                        <h3>{{ $stats['waiting'] }}</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <i class="fas fa-volume-up mb-2"></i>
                        <h5>Dipanggil</h5>
                        <h3>{{ $stats['called'] }}</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <i class="fas fa-check-circle mb-2"></i>
                        <h5>Selesai</h5>
                        <h3>{{ $stats['done'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/call-tts.js') }}"></script>
    <script>
        // Update jam digital
        function updateClock() {
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
            document.getElementById('clock').textContent = now.toLocaleDateString('id-ID', options);
        }

        // Update setiap detik
        setInterval(updateClock, 1000);
        updateClock();

        // Fungsi untuk refresh data
        function refreshDisplay() {
            $.get('{{ route("display.updates") }}', function(data) {
                if (data.currentTicket) {
                    // Update nomor yang sedang dipanggil
                    if ($('.number').text() !== data.currentTicket.number) {
                        $('.number').text(data.currentTicket.number);
                        // Panggil nomor menggunakan TTS
                        window.speakText(`Nomor antrian ${data.currentTicket.number}, silakan menuju ke loket`);
                    }
                }

                // Update daftar tunggu
                let waitingHtml = '';
                data.waitingTickets.forEach(ticket => {
                    const time = new Date(ticket.created_at).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    waitingHtml += `
                        <div class="waiting-number d-flex justify-content-between align-items-center">
                            <span>${ticket.number}</span>
                            <small class="text-muted">${time}</small>
                        </div>
                    `;
                });

                if (!waitingHtml) {
                    waitingHtml = `
                        <div class="text-center text-muted">
                            <i class="fas fa-check-circle fa-3x mb-3"></i>
                            <p>Tidak ada antrian menunggu</p>
                        </div>
                    `;
                }

                $('.waiting-list').html(`
                    <h3 class="mb-4">
                        <i class="fas fa-list"></i> ANTRIAN BERIKUTNYA
                    </h3>
                    ${waitingHtml}
                `);

                // Update recently called
                let recentlyCalledHtml = '';
                data.recentlyCalled.forEach(ticket => {
                    recentlyCalledHtml += `
                        <div class="col-4 mb-2">
                            <div class="p-2 bg-success bg-opacity-25 rounded text-center">
                                ${ticket.number}
                            </div>
                        </div>
                    `;
                });
                $('.recently-called .row').html(recentlyCalledHtml);
            });
        }

        // Refresh setiap 3 detik
        setInterval(refreshDisplay, 3000);
    </script>
</body>
</html>
