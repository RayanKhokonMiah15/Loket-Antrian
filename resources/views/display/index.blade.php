@extends('layouts.frontend')

@section('content')
    <div class="modern-display">
        <!-- Header Section -->
        <div class="header-section">
            <div class="logo-section">
                <img src="{{ asset('Image/logoptun-removebg-preview.png') }}" alt="PTUN Logo" class="ptun-logo">
                <div class="title-section">
                    <h1>Sistem Antrian PTUN</h1>
                    <p class="subtitle">Pengadilan Tata Usaha Negara Bandung</p>
                </div>
            </div>
            <div class="info-section">
                <div class="time-section">
                    <div class="digital-clock" id="clock"></div>
                    <div class="date" id="date"></div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content-grid">
            <!-- Current Number Section -->
            <div class="current-number-section">
                <div class="section-card primary-card">
                    <div class="card-header">
                        <i class="fas fa-broadcast-tower pulse-icon"></i>
                        <h2>NOMOR ANTRIAN SAAT INI</h2>
                    </div>
                    <div class="number-display">
                        @if($currentTicket)
                            <div class="current-number-animation">{{ $currentTicket->display_number }}</div>
                            <div class="status-badge">
                                <i class="fas fa-volume-up"></i> Sedang Dipanggil
                            </div>
                        @else
                            <div class="current-number-animation empty">---</div>
                            <div class="status-badge waiting">
                                <i class="fas fa-clock"></i> Menunggu Antrian
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Queue Information -->
            <div class="queue-info-section">
                <!-- Next in Queue -->
                <div class="section-card secondary-card" style="margin-bottom: 2rem;">
                    <div class="card-header">
                        <i class="fas fa-list-ol"></i>
                        <h3>ANTRIAN BERIKUTNYA</h3>
                    </div>
                    <div class="queue-list">
                        @forelse($waitingTickets as $ticket)
                            <div class="queue-item" data-aos="fade-left" data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="queue-number">{{ $ticket->display_number }}</div>
                                <div class="queue-time">{{ $ticket->created_at->format('H:i') }}</div>
                            </div>
                        @empty
                            <div class="empty-queue">
                                <i class="fas fa-check-circle"></i>
                                <p>Tidak ada antrian menunggu</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recently Called -->
                <div class="section-card secondary-card">
                    <div class="card-header">
                        <i class="fas fa-history"></i>
                        <h3>TERAKHIR DIPANGGIL</h3>
                    </div>
                    <div class="recent-grid" id="recentlyCalledGrid">
                        @foreach($recentlyCalled as $ticket)
                            <div class="recent-item {{ $loop->first ? 'latest' : '' }}">
                                <div class="recent-content">
                                    <div class="recent-number">{{ $ticket->display_number }}</div>
                                    <div class="recent-time">{{ $ticket->updated_at->format('H:i') }}</div>
                                    @if($loop->first)
                                        <div class="recent-indicator">Baru Dipanggil</div>
                                    @endif
                                </div>
                                <div class="recent-status"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="stats-section">
            <div class="stat-grid">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="0">
                    <div class="stat-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['total'] }}</div>
                        <div class="stat-label">Total Hari Ini</div>
                    </div>
                </div>
                <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-icon waiting">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['waiting'] }}</div>
                        <div class="stat-label">Menunggu</div>
                    </div>
                </div>
                <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon called">
                        <i class="fas fa-volume-up"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['called'] }}</div>
                        <div class="stat-label">Dipanggil</div>
                    </div>
                </div>
                <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-icon completed">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['done'] }}</div>
                        <div class="stat-label">Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
:root {
    --primary-color: rgba(27, 94, 32, 0.95); /* Hijau transparan */
    --secondary-color: rgba(46, 125, 50, 0.9); /* Hijau sekunder transparan */
    --accent-color: #4CAF50;
    --success-color: #2ECC71;
    --warning-color: #F1C40F;
    --danger-color: #E74C3C;
    --text-primary: #ECF0F1;
    --text-secondary: #BDC3C7;
    --card-bg: rgba(27, 94, 32, 0.85); /* Card background hijau transparan */
    --gradient-primary: linear-gradient(135deg, rgba(27, 94, 32, 0.9), rgba(76, 175, 80, 0.9));
    --gradient-secondary: linear-gradient(135deg, rgba(46, 125, 50, 0.9), rgba(129, 199, 132, 0.9));
    --shadow-soft: 0 4px 6px rgba(0, 0, 0, 0.1);
    --shadow-strong: 0 8px 15px rgba(0, 0, 0, 0.2);
    --transition-speed: 0.3s;
}

/* Modern Display Styles */
.modern-display {
    min-height: 100vh;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(27, 94, 32, 0.95), rgba(46, 125, 50, 0.85));
    color: var(--text-primary);
    overflow-x: hidden;
}

/* Header Section */
.header-section {
    background: var(--card-bg);
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: var(--shadow-soft);
}

.logo-section {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.ptun-logo {
    height: 60px;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

.title-section h1 {
    font-size: 1.8rem;
    font-weight: 600;
    margin: 0;
    background: linear-gradient(45deg, var(--text-primary), var(--accent-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.subtitle {
    color: var(--text-secondary);
    margin: 0;
    font-size: 0.9rem;
}

.time-section {
    text-align: right;
}

.digital-clock {
    font-size: 1.5rem;
    color: #fff;
    font-family: 'Segoe UI', sans-serif;
}

.date {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.85rem;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem; /* Increased gap between sections */
    margin-bottom: 3rem; /* Increased bottom margin */
}

/* Section Cards */
.section-card {
    background: var(--card-bg);
    border-radius: 15px;
    padding: 2rem;
    box-shadow: var(--shadow-soft);
    transition: all var(--transition-speed) ease;
    backdrop-filter: blur(10px); /* Adds frosted glass effect */
    -webkit-backdrop-filter: blur(10px);
}

.section-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-strong);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.card-header i {
    font-size: 1.5rem;
    color: var(--accent-color);
}

.card-header h2, .card-header h3 {
    margin: 0;
    font-weight: 600;
}

/* Current Number Styles */
.number-display {
    text-align: center;
    padding: 2rem 0;
}

.current-number-animation {
    font-size: 5rem;
    font-weight: 700;
    color: var(--accent-color);
    text-shadow: 0 0 20px rgba(52, 152, 219, 0.3);
    animation: numberPulse 2s infinite ease-in-out;
}

.status-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    background: rgba(52, 152, 219, 0.2);
    color: var(--accent-color);
    font-weight: 500;
    margin-top: 1rem;
}

/* Queue List Styles */
.queue-list {
    display: flex;
    flex-direction: column;
    gap: 1rem; /* Increased gap between queue items */
    margin-top: 1rem; /* Added top margin */
    margin-bottom: 1rem; /* Added bottom margin */
}

.queue-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.2rem; /* Increased padding */
    background: rgba(255, 255, 255, 0.08); /* Slightly more visible background */
    border-radius: 12px;
    transition: all var(--transition-speed) ease;
    border: 1px solid rgba(255, 255, 255, 0.1); /* Added subtle border */
}

.queue-item:hover {
    background: rgba(255, 255, 255, 0.12);
    transform: translateX(5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.queue-number {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-primary);
}

.queue-time {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

/* Recent Grid */
.recent-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.2rem;
    padding: 0.5rem;
}

.recent-item {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 12px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.recent-content {
    padding: 1.2rem;
    text-align: center;
    position: relative;
    z-index: 2;
}

.recent-number {
    font-size: 1.8rem;
    font-weight: 500;
    color: #ffffff;
    margin-bottom: 0.3rem;
    transition: all 0.3s ease;
}

.recent-time {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.6);
    font-weight: 400;
}

.recent-indicator {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    font-size: 0.7rem;
    background: rgba(46, 213, 115, 0.2);
    color: #2ed573;
    padding: 0.3rem 0.6rem;
    border-radius: 12px;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.recent-item.latest {
    background: rgba(255, 255, 255, 0.05);
}

.recent-item.latest .recent-indicator {
    opacity: 1;
    transform: translateY(0);
}

.recent-status {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(to right, #2ed573, transparent);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.recent-item.latest .recent-status {
    transform: scaleX(1);
}

.recent-item.new-call {
    animation: highlightRecent 1s ease-out;
}

@keyframes highlightRecent {
    0% {
        transform: scale(1.05);
        background: rgba(255, 255, 255, 0.1);
    }
    100% {
        transform: scale(1);
        background: rgba(255, 255, 255, 0.03);
    }
}

/* Stats Section */
.stats-section {
    margin-top: 2rem;
    padding: 1rem;
}

.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
    margin: 3rem 0;
    padding: 0 1rem;
}

.stat-card {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.05);
    transition: all 0.3s ease;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(to right, 
        rgba(255,255,255,0.1), 
        rgba(255,255,255,0.05), 
        transparent);
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
}

.stat-icon {
    font-size: 1.4rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0.8rem;
    position: relative;
    z-index: 1;
}

.stat-info {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
    position: relative;
    z-index: 1;
}

.stat-value {
    font-size: 2.6rem;
    font-weight: 300;
    color: #ffffff;
    line-height: 1;
    font-family: 'Segoe UI', system-ui, sans-serif;
    margin-bottom: 0.3rem;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.stat-label {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.75rem;
    font-weight: 400;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    transition: color 0.3s ease;
}

.stat-card::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 16px;
    background: radial-gradient(
        circle at top left,
        rgba(255, 255, 255, 0.03),
        transparent 70%
    );
    pointer-events: none;
}

.stat-card:hover {
    background: rgba(255, 255, 255, 0.05);
    transform: translateY(-2px);
    box-shadow: 
        0 5px 15px rgba(0, 0, 0, 0.1),
        0 0 20px rgba(255, 255, 255, 0.05);
}

.stat-card:hover .stat-value {
    text-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.stat-card:hover .stat-label {
    color: rgba(255, 255, 255, 0.9);
}

@media (max-width: 1400px) {
    .stat-grid {
        gap: 1.5rem;
    }
    
    .stat-value {
        font-size: 2.2rem;
    }
}

@media (max-width: 1200px) {
    .stat-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        padding: 0 0.5rem;
    }
    
    .stat-card {
        padding: 1.2rem;
    }
}

@media (max-width: 768px) {
    .stat-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .stat-value {
        font-size: 2rem;
    }
    
    .stat-card {
        padding: 1rem;
    }
}

@media (max-width: 1200px) {
    .stat-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }
    
    .stat-value {
        font-size: 1.8rem;
    }
}

@media (max-width: 768px) {
    .stat-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}

/* Animations */
@keyframes numberPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.pulse-icon {
    animation: pulse 2s infinite;
    color: var(--accent-color);
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .stat-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .header-section {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .logo-section {
        flex-direction: column;
        gap: 1rem;
    }
    
    .time-section {
        text-align: center;
    }
    
    .current-number-animation {
        font-size: 4rem;
    }
    
    .stat-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        padding: 1rem;
    }
}

.stat-box {
    text-align: center;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.stat-box:hover {
    transform: translateY(-5px);
}

.stat-box i {
    font-size: 2.5rem;
    color: var(--text-color);
    margin-bottom: 1rem;
    opacity: 0.9;
}

.stat-box h5 {
    color: var(--text-color);
    margin: 0.5rem 0;
    font-weight: 600;
    opacity: 0.8;
}

.stat-box h3 {
    color: var(--text-color);
    margin: 0;
    font-size: 2.2rem;
    font-weight: 700;
    text-shadow: 0 0 10px rgba(255,255,255,0.3);
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes scaleIn {
    from { transform: scale(0.9); }
    to { transform: scale(1); }
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.8; }
    100% { opacity: 1; }
}

@media (max-width: 768px) {
    .display-container {
        padding: 1rem;
    }

    .number {
        font-size: 3.5rem;
    }

    .waiting-number {
        font-size: 1.1rem;
        padding: 1rem;
    }

    .stats-container .row > div {
        margin-bottom: 1rem;
    }

    .stat-box {
        padding: 1rem;
    }

    .stat-box h3 {
        font-size: 1.8rem;
    }
}
</style>
@endpush

@push('scripts')
<!-- Optimized Queue Display System -->
<script src="{{ asset('js/queue-display.js') }}"></script>
<script>
    // Optimized initialization
    document.addEventListener('DOMContentLoaded', () => {
        const updateInterval = 5000; // 5 seconds
        let lastUpdate = 0;
        let requestInProgress = false;

        function updateElement(element, newValue, withAnimation = true) {
            if (!element || element.textContent === newValue) return;
            
            if (withAnimation) {
                element.style.transition = 'transform 0.3s ease';
                element.style.transform = 'scale(1.1)';
            }
            
            element.textContent = newValue;

            if (withAnimation) {
                setTimeout(() => {
                    element.style.transform = 'scale(1)';
                }, 50);
            }
        }

        function refreshDisplay() {
            if (requestInProgress) return;
            
            const now = Date.now();
            if (now - lastUpdate < updateInterval) return;
            
            requestInProgress = true;
            lastUpdate = now;

            fetch('{{ route("display.updates") }}')
                .then(response => response.json())
                .then(data => {
                    // Update current number
                    if (data.currentTicket) {
                        const currentNumber = data.currentTicket.display_number || '---';
                        const display = document.querySelector('.current-number-animation');
                        
                        if (display && display.textContent !== currentNumber) {
                            updateElement(display, currentNumber);
                            QueueSystem.announceNumber(currentNumber);
                        }
                    }

                    // Update waiting list
                    if (data.waitingTickets) {
                        const container = document.getElementById('waitingList');
                        if (container) {
                            const fragment = document.createDocumentFragment();
                            data.waitingTickets.forEach(ticket => {
                                const item = document.createElement('div');
                                item.className = 'queue-item';
                                item.innerHTML = `
                                    <span class="queue-number">${ticket.display_number}</span>
                                    <span class="queue-time">${new Date(ticket.created_at)
                                        .toLocaleTimeString('id-ID', {
                                            hour: '2-digit',
                                            minute: '2-digit'
                                        })}</span>
                                `;
                                fragment.appendChild(item);
                            });
                            
                            requestAnimationFrame(() => {
                                container.innerHTML = '';
                                container.appendChild(fragment);
                            });
                        }
                    }

                    // Update recently called numbers
                    if (data.recentlyCalled) {
                        const recentContainer = document.querySelector('.recent-grid');
                        if (recentContainer) {
                            const fragment = document.createDocumentFragment();
                            data.recentlyCalled.forEach(ticket => {
                                const item = document.createElement('div');
                                item.className = 'recent-item';
                                item.textContent = ticket.display_number;
                                fragment.appendChild(item);
                            });
                            
                            requestAnimationFrame(() => {
                                recentContainer.innerHTML = '';
                                recentContainer.appendChild(fragment);
                            });
                        }
                    }

                    // Update statistics
                    if (data.stats) {
                        Object.entries(data.stats).forEach(([key, value]) => {
                            updateElement(document.querySelector(`#${key}`), value);
                        });
                    }
                })
                .catch(error => {
                    console.error('Failed to refresh display:', error);
                })
                .finally(() => {
                    requestInProgress = false;
                });
        }

        // Initial load and set up periodic refresh
        refreshDisplay();
        setInterval(refreshDisplay, updateInterval);

        // Add support for keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // Alt + D to toggle dark mode
            if (e.altKey && e.key.toLowerCase() === 'd') {
                const darkModeToggle = document.getElementById('darkModeToggle');
                if (darkModeToggle) {
                    darkModeToggle.click();
                }
            }
            // Alt + R to manually refresh
            if (e.altKey && e.key.toLowerCase() === 'r') {
                refreshDisplay();
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    /* Optimized styles without external dependencies */
    .error-notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: var(--danger-color);
        color: white;
        padding: 1rem 2rem;
        border-radius: 8px;
        animation: slideIn 0.3s ease-out;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        z-index: 1000;
    }

    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    /* Dark Mode Styles */
    .dark-mode {
        --primary-color: #1a1a1a;
        --secondary-color: #2d2d2d;
        --card-bg: rgba(45, 45, 45, 0.95);
        --text-primary: #ffffff;
        --text-secondary: #a0a0a0;
    }

    /* Additional Animations */
    .blink {
        animation: blink 1s infinite;
    }

    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    .loading {
        position: relative;
        pointer-events: none;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* Responsive Improvements */
    @media (max-width: 768px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .recent-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }

        .current-number-animation {
            font-size: 3.5rem;
        }
    }
</style>
@endpush
