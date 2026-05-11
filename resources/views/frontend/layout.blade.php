<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JEFFLOID PRODUCT</title>

    <link rel="icon" type="image/jpg" href="{{ asset('frontend/icon/akun.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100vh;
            background-color: #1e2022;
            color: white;
            z-index: 1000;
        }

        .content-area {
            margin-left: 220px;
        }

        .menu-item {
            display: block;
            padding: 12px;
            margin: 10px;
            text-decoration: none;
            color: white;
            border-radius: 8px;
            transition: 0.3s;
        }

        .menu-item:hover {
            background-color: #5a6268;
        }

        .menu-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            object-fit: contain;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h5 class="text-center mb-4 mt-3">Menu</h5>

        <a href="{{ route('home') }}" class="menu-item">
            <img src="{{ asset('frontend/icon/beranda.png') }}" class="menu-icon">
            Beranda
        </a>

        <a href="#" class="menu-item" onclick="comingSoon('Chat Kami')">
            💬 Chat Kami
        </a>

        <a href="{{ route('cek.pesanan') }}" class="menu-item">
            <img src="{{ asset('frontend/icon/mata.jpg') }}" class="menu-icon">
            Cek Pesanan
        </a>

        @auth('customer')
        <a href="{{ route('profile') }}" class="menu-item">
            <i class="bi bi-person-fill me-2"></i>
            Profil Saya
        </a>
        @endauth

        <a href="{{ route('keranjang.index') }}" class="menu-item">
            <i class="bi bi-cart-fill me-2"></i>
            Lihat Keranjang
        </a>
    </div>

    <!-- CONTENT -->
    <div class="content-area">

        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                    JEFFLOID
                </a>

                <div class="ms-auto d-flex align-items-center">

                    @auth('customer')
                        <span class="me-3 fw-semibold">
                            {{ Auth::guard('customer')->user()->name }}
                        </span>

                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('auth.login') }}" class="btn btn-primary btn-sm">
                               Login
                    </a>
                    @endauth

                </div>
            </div>
        </nav>

        <!-- HEADER -->
        <header class="bg-dark py-3">
            <div class="container text-center text-white">
                <h2 class="fw-bold mb-1">SEMBAKO ELIT</h2>
                <small class="text-white-50">Biar hidup belajar hemat</small>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <div class="container mt-3">
            @yield('content')
        </div>

        <!-- FOOTER -->
        <footer class="bg-white text-dark text-center py-2 mt-4">
            <p class="mb-0 small">© {{ date('Y') }} jeffloidshop</p>
        </footer>

    </div>

    <script>
        function comingSoon(fitur) {
            alert(fitur + ' masih dalam pengembangan 🚧');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>