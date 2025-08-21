<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Antrian PTUN Bandung</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">

    <!-- Additional Styles -->
    @stack('styles')

    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header-logo {
            max-height: 100px;
            margin-bottom: 1rem;
        }

        .divider {
            width: 50px;
            height: 3px;
            background: #0d6efd;
            margin: 1rem auto;
            border-radius: 2px;
        }

        .main-content {
            flex: 1;
            padding: 2rem 0;
        }

        footer {
            background: #333;
            color: white;
            padding: 1rem 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <div class="main-content">
        @yield('content')
    </div>

    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Pengadilan Tata Usaha Negara Bandung. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (if needed) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
