<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .register-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .register-title {
            color: #311046;
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #311046;
            box-shadow: 0 0 0 0.15rem rgba(49, 16, 70, 0.15);
        }

        .btn-register {
            background-color: #ff9800;
            color: #ffffff;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            padding: 10px;
        }

        .btn-register:hover {
            background-color: #e68900;
        }

        .login-link a {
            color: #311046;
            font-weight: bold;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <h2 class="register-title">Daftar Akun</h2>

        <form action="/register" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-register w-100">Daftar</button>
        </form>

        <p class="text-center mt-3 login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login</a>
        </p>
    </div>

</body>
</html>