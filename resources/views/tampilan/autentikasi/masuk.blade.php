@extends('struktur.dasar')
@push('meta')
    <meta content="{{ csrf_token() }}" name="token-csrf">
@endpush
@section('judul', 'Masuk')
@push('css')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endpush
@section('konten')
    <div class="col-lg-6 col-md-8 col-xl-5">
        {{-- kartu --}}
        <div class="card">
            <div class="card-body">
                <h2 class="fs-4 fw-bold mb-3 text-center text-uppercase">Selamat Datang!</h2>
                <form name="masuk">
                    <input autofocus class="form-control mb-3" name="nama-pengguna" placeholder="Nama pengguna" type="text">
                    <input class="form-control mb-3" name="kata-sandi" placeholder="Kata sandi" type="password">
                    <div class="d-grid w-full">
                        <button class="btn" type="submit">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- kartu --}}
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="{{ asset('js/autentikasi/masuk.js') }}"></script>
@endpush
