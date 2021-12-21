<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Tutorial Laravel Mail | ayongoding.com</title>
</head>
<body>
    <p>Hallo <b>{{$user['name']}}</b> berikut ini adalah komentar Anda:</p>

    <a href="{{ url('/aktivasiAkun') }}/{{ $user['token'] }}">{{ $user['token'] }}</a>
    <br>

    <small>Klik Link Di Atas Untuk Aktifasi Akun</small>

    <p>Terimakasih <b>{{$user['name']}}</b> telah memberi komentar.</p>
</body>
</html>