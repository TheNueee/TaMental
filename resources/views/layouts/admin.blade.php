<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 240px;
            background-color: #343a40;
            color: white;
            flex-shrink: 0;
        }

        .sidebar .nav-link {
            color: #ddd;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #495057;
            color: #fff;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        .sidebar h5 {
            padding: 15px 20px;
            border-bottom: 1px solid #495057;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="sidebar d-flex flex-column">
        <h5>Admin Panel</h5>
        <nav class="nav flex-column px-2">
            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="nav-link {{ request()->is('admin/professionals*') ? 'active' : '' }}" href="{{ route('admin.professionals.index') }}">Akun Profesional</a>
            <a class="nav-link {{ request()->is('admin/layanans*') ? 'active' : '' }}" href="{{ route('admin.layanans.index') }}">Layanan</a>
            <form action="{{ route('logout') }}" method="POST" class="mt-3 px-2">
                @csrf
                <button class="btn btn-danger w-100">Logout</button>
            </form>
        </nav>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
