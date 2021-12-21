<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Tutorial Laravel Mail | ayongoding.com</title>
</head>
<body>
    <p>Hallo <b>{{$user['nama']}}</b> berikut ini adalah komentar Anda:</p>

    <a href="{{ url('/ubahPassword') }}/{{ $user['id'] }}/{{ $user['token'] }}}">{{ url('/ubahPassword') }}{{ $user['id'] }}{{ $user['token'] }}</a>
    {{-- <a href="{{ url('/ubahPassword') }}/{{ $user['id'] }}/{{ $user['token'] }}}">{{ url('/ubahPassword') }}?id={{ $user['id'] }}&token={{ $user['token'] }}</a> --}}
    <br>
    
    <small>Klik Link Di Atas Untuk Ubah Password</small>

    <p>Terimakasih <b>{{$user['nama']}}</b> telah memberi komentar.</p>
</body>
</html>