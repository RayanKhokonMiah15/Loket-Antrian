<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Antrian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .ticket-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }
        .ticket-button {
            border-radius: 15px;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
        }
        .ticket-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            background: linear-gradient(135deg, #0a58ca, #084298);
        }
        .ticket-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            display: none;
            z-index: 1000;
        }
        .ticket-number {
            font-size: 3.5rem;
            font-weight: 700;
            margin: 1rem 0;
            color: #0d6efd;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 999;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center mb-5">
                    <h1 class="display-4">Selamat Datang</h1>
                    <p class="lead">Silahkan ambil nomor antrian anda</p>
                </div>
                <div class="col-12 text-center">
                    <button class="ticket-button" data-prefix="A">
                        Klik Disini Untuk Mendapatkan Nomor Antrian
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay"></div>
    <div class="ticket-modal">
        <h2 class="mb-4">Nomor Antrian Anda</h2>
        <div class="ticket-number display-1 fw-bold"></div>
        <p class="text-muted mt-4">Mohon tunggu sampai nomor anda dipanggil</p>
        <button class="btn btn-primary btn-lg mt-4 px-5" onclick="closeModal()">Tutup</button>
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
                ticketButton.innerHTML = 'Klik Disini Untuk Mendapatkan Nomor Antrian';
            }
        }

        // Add click event listener
        ticketButton.addEventListener('click', createTicket);

        function showTicketModal(ticketNumber) {
            document.querySelector('.ticket-number').textContent = ticketNumber;
            document.querySelector('.overlay').style.display = 'block';
            document.querySelector('.ticket-modal').style.display = 'block';
        }

        function closeModal() {
            document.querySelector('.overlay').style.display = 'none';
            document.querySelector('.ticket-modal').style.display = 'none';
        }
    </script>
</body>
</html>
