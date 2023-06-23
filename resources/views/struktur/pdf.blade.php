<!DOCTYPE html>
<html lang="id">
<head>
    {{-- meta --}}
    <meta charset="utf-8">
    {{-- meta --}}
    <title>@yield('judul') - {{ config('app.name') }}</title>
    {{-- css --}}
    @stack('css')
    {{-- css --}}
</head>
<body>
@yield('konten')
</body>
</html>
