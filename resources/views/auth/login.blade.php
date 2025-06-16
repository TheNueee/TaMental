<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url('/images/auth/loginregisterbg.png'); /* Ganti dengan path gambar Anda */
            background-size: cover; /* Mengatur gambar agar menutupi seluruh latar belakang */
        }
        .login-container {
            max-width: 400px;   
            margin: 80px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Shadow lembut */
        }
        .login-title {
            color: #8D0B41; /* Warna primary */
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #8D0B41;
            border-color: #8D0B41;
        }
        .btn-primary:hover {
            background-color: #D39D55; /* Warna hover */
            border-color: #D39D55;
        }
        .form-control:focus {
            border-color: #8D0B41;
            box-shadow: 0 0 5px rgba(141, 11, 65, 0.4); /* Highlight pada input */
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .success-message {
            color: green;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .register-link {
            font-size: 14px;
            text-align: center;
            margin-top: 15px;
        }
        .register-link a {
            color: #8D0B41;
            font-weight: 600;
            text-decoration: none;
        }
        .register-link a:hover {
            color: #D39D55;
        }
        .back-to-dashboard {
            position: absolute;
            top: 20px;
            left: 20px;
        }
        .back-to-dashboard a {
            color: #e7e7e7;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
        }
        .back-to-dashboard a:hover {
            color: #D39D55;}
    </style>
</head>
<body>
    <div class="back-to-dashboard">
        <a href="/">← Back to Dashboard</a>
    </div>
    
    <div class="container">
        <div class="login-container">
            <h1 class="login-title">Masuk</h1>

            @if ($errors->any())
                <div class="error-message">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="Masukkan email Anda">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Masukkan password Anda">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>

            <div class="register-link">
                <p>Belum memiliki akun? <a href="{{ route('register') }}">Buat akun penghuni baru di sini</a>.</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
