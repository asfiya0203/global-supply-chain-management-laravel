<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard_admin</title>
</head>
<body>
    <h1>DASHBOARD ADMIN</h1>

    <h2>Data Pengguna</h2>

<table border="1">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
    </tr>

    @foreach($pengguna as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->email }}</td>
    </tr>
    @endforeach
</table>
</body>
</html>