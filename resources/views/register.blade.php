<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER</title>
</head>
<body>
    <h1>HALAMAN REGISTER</h1>

    <form action="/register" method='POST'>
        @csrf
        <input type="text" name="name" placeholder="Usernama" required><br><br>
        <input type="email" name="email" placeholder="email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>

        <button type="submit">Daftar</button>
    </form>
    <p>sudah punya akun? lakukan <a href="{{route('login')}}">Login</a></p>
</body>
</html>