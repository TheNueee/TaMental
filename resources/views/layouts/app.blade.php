<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Custom CSS --}}
    <style>
        :root {
            --primary-orange: #F4A261;
            --secondary-orange: #E76F51;
            --text-dark: #2D3748;
            --text-light: #718096;
            --border-light: #E2E8F0;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --border-radius-lg: 12px;
            --border-radius-full: 9999px;
        }

        body {
            font-family: 'Lexend Deca', sans-serif;
            font-weight: 400;
            line-height: 1.6;
            color: var(--text-dark);
            padding-top: 0;
        }

        /* Navbar Styles */
        .custom-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-light);
            border-radius: var(--border-radius-lg);
            padding: 8px 24px;
            width: 95%;
            max-width: 1200px;
            margin: 16px auto;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .custom-navbar:hover {
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
            color: var(--text-dark) !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-logo {
            height: 32px;
            width: auto;
            object-fit: contain;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            font-size: 0.95rem;
            color: var(--text-dark) !important;
            padding: 8px 16px !important;
            margin: 0 4px;
            border-radius: 8px;
            transition: all 0.2s ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-orange) !important;
            background-color: rgba(244, 162, 97, 0.1);
            transform: translateY(-1px);
        }

        .navbar-nav .nav-link:active,
        .navbar-nav .nav-link.active {
            color: var(--primary-orange) !important;
            background-color: rgba(244, 162, 97, 0.15);
        }

        /* CTA Button Styles */
        .btn-cta {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
            border: none;
            border-radius: var(--border-radius-full);
            padding: 10px 24px;
            font-size: 0.95rem;
            font-weight: 600;
            color: white !important;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
            min-width: 120px;
            white-space: nowrap;
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(244, 162, 97, 0.4);
            color: white !important;
            opacity: 0.95;
        }

        .btn-cta:active {
            transform: translateY(0);
            box-shadow: var(--shadow-sm);
        }

        .btn-cta2 {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
            border: none;
            border-radius: var(--border-radius-full);
            padding: 14px 32px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white !important;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
            min-width: 160px;
            white-space: nowrap;
        }

        .btn-cta2:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px -5px rgba(244, 162, 97, 0.5);
            color: white !important;
            opacity: 0.95;
        }

        .btn-cta2:active {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Login Link */
        .btn-login {
            color: var(--primary-orange) !important;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 10px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-login:hover {
            color: var(--secondary-orange) !important;
            background-color: rgba(244, 162, 97, 0.1);
            transform: translateY(-1px);
        }

        /* Primary Text */
        .primarytext {
            color: var(--primary-orange);
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .custom-navbar {
                width: 95%;
                margin: 12px auto;
                padding: 12px 16px;
            }

            .navbar-nav .nav-link {
                padding: 12px 8px !important;
                margin: 2px 0;
            }

            .btn-cta {
                padding: 12px 20px;
                font-size: 0.9rem;
                min-width: 100px;
            }

            .btn-cta2 {
                padding: 14px 24px;
                font-size: 1rem;
                min-width: 140px;
            }

            .navbar-collapse {
                margin-top: 16px;
                padding-top: 16px;
                border-top: 1px solid var(--border-light);
            }

            .d-flex.align-items-center {
                flex-direction: column;
                gap: 12px;
                align-items: stretch !important;
            }

            .d-flex.align-items-center > * {
                text-align: center;
            }
        }

        /* Navbar Toggle Button */
        .navbar-toggler {
            border: none;
            padding: 4px 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .navbar-toggler:hover {
            background-color: rgba(244, 162, 97, 0.1);
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(244, 162, 97, 0.25);
        }

        /* Footer */
        .footer {
            background-color: #f8f9fa;
            border-top: 1px solid var(--border-light);
            margin-top: 60px;
        }

        /* Main Content */
        main {
            padding-top: 100px;
        }

        @media (max-width: 768px) {
            main {
                padding-top: 120px;
            }
        }

        /* Animation for page load */
        .custom-navbar {
            animation: slideDown 0.6s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-md fixed-top custom-navbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-kamidengar.png') }}" alt="KamiDengar" class="navbar-logo">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('disclaimer') ? 'active' : '' }}" href="{{ route('disclaimer') }}">Pengujian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('daftarprofesional') ? 'active' : '' }}" href="{{ route('daftarprofesional')}}">Konsultasi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('tentang-kami') ? 'active' : '' }}" href="#">Tentang Kami</a>
                            </li>
                        @else
                            @php $role = Auth::user()->role; @endphp

                            @if($role === 'client')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('client/pengujian/riwayat') ? 'active' : '' }}" href="{{ route('client.pengujian.riwayat') }}">Pengujian</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('client/konsultasi') ? 'active' : '' }}" href="{{ route('client.konsultasi.index') }}">Konsultasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Pandora Box</a>
                                </li>
                             @elseif($role === 'professional')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('professional/dashboard') ? 'active' : '' }}" href="{{ route('professional.dashboard') }}">Utama</a>
                                </li> 
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('professional/konsultasi') ? 'active' : '' }}" href="{{ route('professional.konsultasi.index') }}">Jadwal Konsultasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('professional/klien') ? 'active' : '' }}" href="{{ route('professional.klien.index') }}">Daftar Klien</a>
                                </li> 
                            @endif
                        @endguest
                    </ul>

                    <div class="d-flex align-items-center">
                        @guest
                            <a href="{{ route('login.form') }}" class="btn-login me-3">Login</a>
                            <a href="{{ route('register.form') }}" class="btn btn-cta">Daftar Akun</a>
                        @else
                            <a href="#" class="btn-login me-3">Profile</a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-cta">
                                    Logout
                                    <span class="d-none d-lg-inline">{{ Auth::user()->username }}</span>
                                </button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="footer mt-auto py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">&copy; {{ config('app.name') }} {{ date('Y') }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">Built with Laravel</p>
                </div>
            </div>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>