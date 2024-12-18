<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mailData['title'] }}</title>
</head>
<body>
    <h1>{{ $mailData['title'] }}</h1>
    <p>{{ strip_tags($mailData['body'])}}</p>
    <p>{{ strip_tags($mailData['pesan']) }}</p>  <!-- Menampilkan body tanpa tag HTML -->
</body>
</html>
