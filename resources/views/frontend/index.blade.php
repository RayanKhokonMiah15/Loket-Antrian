@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <img src="{{ asset('Image/logoptun-removebg-preview.png') }}" alt="PTUN Logo" class="header-logo">
        <h1 class="display-5 fw-bold text-dark mb-2">Selamat Datang</h1>
        <div class="divider"></div>
        <p class="lead text-muted mb-3">Sistem Antrian Pengadilan Tata Usaha Negara<br>Bandung</p>
        <p class="text-muted mb-4">Silakan pilih jenis layanan yang Anda butuhkan</p>
    </div>

    <div class="row justify-content-center g-4">
        <!-- Loket A - Pendaftaran Perkara -->
        <div class="col-md-6 col-lg-3">
            <div class="counter-card" data-counter="A">
                <div class="counter-icon" style="background: linear-gradient(135deg, #4CAF50, #45a049);">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h4>Loket A</h4>
                <p>Pendaftaran Perkara</p>
                <button class="ticket-button" onclick="getTicket('A')">
                    <i class="fas fa-ticket-alt me-2"></i>
                    Ambil Nomor
                </button>
            </div>
        </div>

        <!-- Loket B - Konsultasi -->
        <div class="col-md-6 col-lg-3">
            <div class="counter-card" data-counter="B">
                <div class="counter-icon" style="background: linear-gradient(135deg, #2196F3, #1e88e5);">
                    <i class="fas fa-comments"></i>
                </div>
                <h4>Loket B</h4>
                <p>Konsultasi Hukum</p>
                <button class="ticket-button" onclick="getTicket('B')">
                    <i class="fas fa-ticket-alt me-2"></i>
                    Ambil Nomor
                </button>
            </div>
        </div>

        <!-- Loket C - Pengambilan Produk -->
        <div class="col-md-6 col-lg-3">
            <div class="counter-card" data-counter="C">
                <div class="counter-icon" style="background: linear-gradient(135deg, #FF9800, #f57c00);">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h4>Loket C</h4>
                <p>Pengambilan Produk</p>
                <button class="ticket-button" onclick="getTicket('C')">
                    <i class="fas fa-ticket-alt me-2"></i>
                    Ambil Nomor
                </button>
            </div>
        </div>

        <!-- Loket D - Informasi -->
        <div class="col-md-6 col-lg-3">
            <div class="counter-card" data-counter="D">
                <div class="counter-icon" style="background: linear-gradient(135deg, #9C27B0, #8e24aa);">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h4>Loket D</h4>
                <p>Informasi Umum</p>
                <button class="ticket-button" onclick="getTicket('D')">
                    <i class="fas fa-ticket-alt me-2"></i>
                    Ambil Nomor
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tiket -->
<div class="modal fade" id="ticketModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <h4 class="modal-title mb-3">Nomor Antrian Anda</h4>
                <div class="ticket-number mb-3"></div>
                <p class="counter-info mb-3"></p>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
:root {
    --ptun-primary: #2E7D32;
    --ptun-secondary: #37474F;
    --ptun-success: #388E3C;
    --ptun-light: #E8F5E9;
}

body {
    background: linear-gradient(135deg, #E8F5E9, #ffffff);
    background-image: 
        linear-gradient(135deg, rgba(46, 125, 50, 0.05) 25%, transparent 25%),
        linear-gradient(225deg, rgba(46, 125, 50, 0.05) 25%, transparent 25%),
        linear-gradient(45deg, rgba(46, 125, 50, 0.05) 25%, transparent 25%),
        linear-gradient(315deg, rgba(46, 125, 50, 0.05) 25%, #E8F5E9 25%);
    background-position: 40px 0, 40px 0, 0 0, 0 0;
    background-size: 80px 80px;
    background-repeat: repeat;
    min-height: 100vh;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }

    .header-logo {
        max-height: 80px;
    }

    .display-5 {
        font-size: 2rem;
    }

    .lead {
        font-size: 1rem;
    }

    .row {
        margin: 0 -0.5rem;
    }

    .col-md-6 {
        padding: 0 0.5rem;
    }

    .counter-card {
        margin-bottom: 1rem;
        padding: 1.5rem;
    }

    .counter-icon {
        width: 60px;
        height: 60px;
        margin-bottom: 1rem;
    }

    .counter-icon i {
        font-size: 1.5rem;
    }

    .counter-card h4 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }

    .counter-card p {
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .ticket-button {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        width: 100%;
    }

    .modal-dialog {
        margin: 1rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .ticket-number {
        font-size: 2.5rem;
        padding: 1.5rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    body {
        background: #1a1a1a;
        color: #ffffff;
    }

    .counter-card {
        background: #2d2d2d;
        border-color: #3d3d3d;
    }

    .counter-card:hover {
        border-color: var(--ptun-primary);
    }

    .counter-card h4 {
        color: #ffffff;
    }

    .counter-card p {
        color: #cccccc;
    }

    .ticket-button {
        color: var(--ptun-primary);
        border-color: var(--ptun-primary);
    }

    .modal-content {
        background: #2d2d2d;
        color: #ffffff;
    }

    .ticket-number {
        background: #3d3d3d;
    }
}

.header-logo {
    max-height: 120px;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
    filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
}

.divider {
    width: 80px;
    height: 4px;
    background: linear-gradient(to right, var(--ptun-primary), var(--ptun-success));
    margin: 1.5rem auto;
    border-radius: 2px;
}

.counter-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 2px solid transparent;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.counter-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(to right, var(--ptun-primary), var(--ptun-success));
    opacity: 0;
    transition: all 0.3s ease;
}

.counter-card:hover::before {
    opacity: 1;
}

.counter-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 20px rgba(46, 125, 50, 0.15);
    border-color: var(--ptun-light);
}

.counter-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    background: var(--ptun-light);
    position: relative;
    z-index: 1;
}

.counter-icon::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: linear-gradient(45deg, var(--ptun-primary), var(--ptun-success));
    z-index: -1;
    opacity: 0;
    transition: all 0.3s ease;
    transform: scale(0.8);
}

.counter-card:hover .counter-icon::after {
    opacity: 1;
    transform: scale(1);
}

.counter-icon i {
    font-size: 2rem;
    color: var(--ptun-primary);
    transition: all 0.3s ease;
}

.counter-card:hover .counter-icon i {
    color: white;
}

.counter-card h4 {
    color: var(--ptun-secondary);
    margin-bottom: 1rem;
    font-weight: 600;
    font-size: 1.5rem;
}

.counter-card p {
    color: #666;
    margin-bottom: 1.5rem;
    font-size: 1rem;
    line-height: 1.6;
}

.ticket-button {
    background: none;
    border: 2px solid var(--ptun-primary);
    padding: 0.75rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    color: var(--ptun-primary);
    transition: all 0.3s ease;
    width: 100%;
    max-width: 200px;
    position: relative;
    overflow: hidden;
}

.ticket-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, var(--ptun-primary), var(--ptun-success));
    z-index: -1;
    opacity: 0;
    transition: all 0.3s ease;
}

.ticket-button:hover::before {
    opacity: 1;
}

.ticket-button:hover {
    color: white;
    transform: translateY(-2px);
}

.modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.modal-body {
    padding: 2.5rem;
}

.ticket-number {
    font-size: 3.5rem;
    font-weight: 700;
    color: var(--ptun-primary);
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    background: var(--ptun-light);
    border-radius: 15px;
    margin: 1.5rem 0;
    position: relative;
    overflow: hidden;
}

.ticket-number::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(to right, var(--ptun-primary), var(--ptun-success));
}

.counter-info {
    color: var(--ptun-secondary);
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }

    .header-logo {
        max-height: 80px;
    }

    .counter-card {
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .counter-icon {
        width: 60px;
        height: 60px;
    }

    .counter-icon i {
        font-size: 1.5rem;
    }

    .counter-card h4 {
        font-size: 1.25rem;
    }

    .ticket-button {
        padding: 0.6rem 1.5rem;
        font-size: 0.9rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .ticket-number {
        font-size: 2.5rem;
    }
}
</style>
</style>
@endpush

@push('scripts')
<script>
function getTicket(counterType) {
    // Disable all ticket buttons while processing
    document.querySelectorAll('.ticket-button').forEach(btn => btn.disabled = true);
    
    fetch('/create-ticket', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ counter_type: counterType })
    })
    .then(async response => {
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Terjadi kesalahan saat membuat nomor antrian');
        }
        
        return data;
    })
    .then(data => {
        if (!data.success) {
            throw new Error(data.message || 'Terjadi kesalahan saat membuat nomor antrian');
        }

        const ticketModal = document.getElementById('ticketModal');
        const modal = bootstrap.Modal.getInstance(ticketModal) || new bootstrap.Modal(ticketModal);
        const ticketNumber = ticketModal.querySelector('.ticket-number');
        const counterInfo = ticketModal.querySelector('.counter-info');
        
        ticketNumber.textContent = data.display_number;
        ticketNumber.style.color = getCounterColor(counterType);
        
        const counterNames = {
            'A': 'Pendaftaran Perkara',
            'B': 'Konsultasi Hukum',
            'C': 'Pengambilan Produk',
            'D': 'Informasi Umum'
        };
        
        counterInfo.textContent = `Silakan menuju ke Loket ${counterType} - ${counterNames[counterType]}`;
        modal.show();
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Maaf, terjadi kesalahan saat membuat nomor antrian. Silakan coba lagi.');
    })
    .finally(() => {
        // Re-enable all ticket buttons
        document.querySelectorAll('.ticket-button').forEach(btn => btn.disabled = false);
    });
}

function getCounterColor(counterType) {
    const colors = {
        'A': '#4CAF50',
        'B': '#2196F3',
        'C': '#FF9800',
        'D': '#9C27B0'
    };
    return colors[counterType];
}
</script>
@endpush
