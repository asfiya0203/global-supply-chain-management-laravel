<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>HALAMAN LOGIN</h1>
    @if(session('info'))
        <p>{{session('info')}}</p>
    @endif
    <form action="/login" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>

        <button type="submit">Login</button>
    </form>
    @if(session('error'))
        <p>{{session('error')}}</p>
    @endif
    <p>Belum punya akun? lakukan <a href="{{route('register')}}">Daftar</a></p>
</body>
</html>
