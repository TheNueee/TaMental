<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url('/images/auth/loginregisterbg.png'); /* Ganti dengan path gambar Anda */
            background-size: cover; /* Mengatur gambar agar menutupi seluruh latar belakang */
        }
        .register-container {
            max-width: 450px;
            margin: 80px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Shadow lembut */
        }
        .register-title {
            color: #8D0B41; /* Warna utama */
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
        .footer-text {
            font-size: 14px;
            text-align: center;
            margin-top: 15px;
        }
        .footer-text a {
            color: #8D0B41;
            font-weight: 600;
            text-decoration: none;
        }
        .footer-text a:hover {
            color: #D39D55;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <h1 class="register-title">Register</h1>

            @if ($errors->any())
                <div class="error-message">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Enter your full name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="Enter your email address">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Create a password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required placeholder="Confirm your password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>

            <div class="footer-text">
                <p>Sudah memiliki akun penghuni? <a href="{{ route('login') }}">Masuk disini</a>.</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
