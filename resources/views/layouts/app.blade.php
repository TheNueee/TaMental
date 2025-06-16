<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 (opsional jika belum pakai Vite) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Tambahan CSS --}}
    <style>
        .custom-navbar {
            background-color: white;
            border-radius: 20px;
            padding: 10px 20px;
            width: 90%;
            margin: 20px auto;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-logo {
            height: 20px;
            object-fit: contain;
        }

        body {
            font-family: 'Lexend Deca', sans-serif;
            padding-top: 40px;
        }

        .btn-cta {
            background: linear-gradient(90deg, #F4A261 0%, #E76F51 100%);
            border-radius: 999px;
            padding: 12px 36px;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .btn-cta:hover {
            opacity: 0.9;
        }

         .btn-cta2 {
            background: linear-gradient(16deg, #F4A261 0%, #E76F51 100%);
            border-radius: 999px;
            padding: 18px 36px;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-cta:hover {
            opacity: 0.9;
        }

        .btn-cta2:hover {
            opacity: 0.9;
        }
        .primarytext {
            color: #F4A261;
            font-weight: bold;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-md fixed-top custom-navbar">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-kamidengar.png') }}" alt="KamiDengar" class="navbar-logo me-2">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        @guest
                            <li class="nav-item"><a class="nav-link" href="{{ route('disclaimer') }}">Pengujian Kesehatan Mental</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Tentang Kami</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Hubungi</a></li>
                        @else
                            @php $role = Auth::user()->role; @endphp

                            @if($role === 'client')
                                <li class="nav-item"><a class="nav-link" href="{{ route('client.dashboard') }}">Utama</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('client.pengujian.riwayat') }}">Pengujian</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Konsultasi</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Pandora Box</a></li>
                            @elseif($role === 'professional')
                                <li class="nav-item"><a class="nav-link" href="{{ route('professional.dashboard') }}">Daftar Appointment</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Jadwal</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Konsultasi</a></li>
                            @endif
                        @endguest
                    </ul>

                    <div class="d-flex align-items-center">
                        @guest
                            <a href="{{ route('login.form') }}" class="btn btn-link text-decoration-none me-2" style="color: #F4A261;">Login</a>
                            <a href="{{ route('register.form') }}" class="btn btn-cta">Daftar Akun</a>
                        @else
                            <a href="#" class="btn btn-link text-decoration-none me-2" style="color: #F4A261;">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-cta">Logout ({{ Auth::user()->username }})</button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main role="main" class="flex-shrink-0 mt-4">
        <div class="container mt-5 pt-5">
            @yield('content')
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-start">&copy; {{ config('app.name') }} {{ date('Y') }}</p>
            <p class="float-end">Built with Laravel</p>
        </div>
    </footer>

    {{-- Bootstrap JS (opsional jika belum pakai Vite) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
