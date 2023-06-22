<!DOCTYPE html>
<html lang="id">
<head>
    {{-- meta --}}
    <meta charset="utf-8">
    <meta content="width=device-width" name="viewport">
    @stack('meta')
    {{-- meta --}}
    <title>@yield('judul') - {{ config('app.name') }}</title>
    {{-- css --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
    @stack('css')
    {{-- css --}}
</head>
<body @if (url()->current() !== route('autentikasi.masuk')) id="page-top" @endif>
@includeWhen(url()->current() === route('autentikasi.masuk'), 'struktur.tata-letak.autentikasi')
@includeUnless(url()->current() === route('autentikasi.masuk'), 'struktur.tata-letak.utama')
{{-- js --}}
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@stack('js')
{{-- js --}}
</body>
</html>
