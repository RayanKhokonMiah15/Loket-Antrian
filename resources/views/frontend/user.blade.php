<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Antrian | PTUN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body>
    <div class="ticket-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="welcome-card">
                        <img src="{{ asset('storage/image/257d0a10466f13acc3c57bffca06f9cfaee1348deb87229b8f5bedfc6345bf74.png') }}" alt="PTUN Logo" class="header-logo">
                        <h1 class="display-5 fw-bold text-dark mb-2">Selamat Datang</h1>
                        <div class="divider"></div>
                        <p class="lead text-muted mb-3">Sistem Antrian Pengadilan Tata Usaha Negara  <br>Bandung </p>
                        <p class="text-muted mb-4">Silakan klik tombol di bawah untuk mengambil nomor antrian Anda</p>
                        <button class="ticket-button" data-prefix="A">
                            <i class="fas fa-ticket-alt"></i>
                            Ambil Nomor Antrian
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay"></div>
    <div class="ticket-modal">
        <div class="modal-content">
            <i class="fas fa-ticket-alt mb-3" style="font-size: 2.5rem; color: var(--ptun-green);"></i>
            <h2 class="h4 mb-4">Nomor Antrian Anda</h2>
            <div class="ticket-number"></div>
            <div class="divider"></div>
            <p class="text-muted">Mohon tunggu sampai nomor Anda dipanggil</p>
            <button class="modal-close mt-4" onclick="closeModal()">
                Tutup
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const ticketButton = document.querySelector('.ticket-button');
        
        async function createTicket() {
            try {
                // Disable button and show loading
                ticketButton.disabled = true;
                ticketButton.innerHTML = 'Memproses...';
                
                const token = document.querySelector('meta[name="csrf-token"]').content;
                
                const response = await fetch('{{ route("user.create-ticket") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ prefix: 'A' })
                });

                const data = await response.json();
                showTicketModal(data.ticket);
            } catch (error) {
                console.error('Error:', error);
                // Still show modal with a fallback number if there's an error
                showTicketModal('001');
            } finally {
                // Re-enable button and restore text
                ticketButton.disabled = false;
                ticketButton.innerHTML = '<i class="fas fa-ticket-alt"></i>Ambil Nomor Antrian';
            }
        }

        // Add click event listener
        ticketButton.addEventListener('click', createTicket);

        function showTicketModal(ticketNumber) {
            const modal = document.querySelector('.ticket-modal');
            const overlay = document.querySelector('.overlay');
            const ticketNumberElement = document.querySelector('.ticket-number');
            
            // Persiapkan modal
            modal.style.display = 'block';
            overlay.style.display = 'block';
            
            // Trigger reflow
            modal.offsetHeight;
            
            // Aktifkan animasi
            modal.classList.add('active');
            overlay.style.opacity = '1';
            
            // Animasi nomor tiket
            ticketNumberElement.style.opacity = '0';
            ticketNumberElement.textContent = ticketNumber;
            setTimeout(() => {
                ticketNumberElement.style.transition = 'opacity 0.5s ease';
                ticketNumberElement.style.opacity = '1';
            }, 100);
        }

        function closeModal() {
            const modal = document.querySelector('.ticket-modal');
            const overlay = document.querySelector('.overlay');
            
            modal.classList.remove('active');
            overlay.style.opacity = '0';
            
            setTimeout(() => {
                modal.style.display = 'none';
                overlay.style.display = 'none';
            }, 300);
        }
    </script>
</body>
</html>
