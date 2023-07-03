@extends('struktur.dasar')
@push('meta')
    <meta content="{{ csrf_token() }}" name="token-csrf">
@endpush
@section('judul', 'Pengguna')
@section('topbar', 'Pengguna')
@section('konten')
    {{-- kartu --}}
    <div class="card my-4 shadow">
        <div class="card-body">
            <form name="tambah-pengguna">
                <div class="mb-3">
                    <label class="form-label" for="nama-pengguna">Nama Pengguna</label>
                    <input autofocus class="form-control" id="nama-pengguna" name="nama-pengguna" type="text">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="kata-sandi">Kata Sandi</label>
                    <input class="form-control" id="kata-sandi" name="kata-sandi" type="password">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="nama-depan">Nama Depan</label>
                    <input class="form-control" id="nama-depan" name="nama-depan" type="text">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="nama-belakang">Nama Belakang</label>
                    <input class="form-control" id="nama-belakang" name="nama-belakang" type="text">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="level">Level</label>
                    <select class="form-select" id="level" name="level">
                        <option selected>Pilih...</option>
                        <option>Admin</option>
                        <option>Pemilik</option>
                        <option>Cabang</option>
                    </select>
                </div>
                <button class="btn btn-secondary" id="tombol-batal" type="button">Batal</button>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </form>
        </div>
    </div>
    {{-- kartu --}}
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="{{ asset('js/master/pengguna/tambah.js') }}"></script>
@endpush
