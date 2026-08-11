<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pesan Baru dari Formulir Kontak</title>
</head>
<body style="font-family: sans-serif; color: #1a1a1a;">
    <h2>Pesan baru masuk dari formulir kontak {{ config('village.name') }}</h2>
    <p><strong>Nama:</strong> {{ $contactMessage->name }}</p>
    <p><strong>Email:</strong> {{ $contactMessage->email }}</p>
    <p><strong>Pesan:</strong></p>
    <p>{{ $contactMessage->message }}</p>
    <hr>
    <p style="color:#666; font-size: 12px;">Dikirim {{ $contactMessage->created_at->translatedFormat('d F Y, H:i') }} WIB.</p>
</body>
</html>
