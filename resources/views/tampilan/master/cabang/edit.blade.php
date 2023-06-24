@extends('struktur.dasar')
@push('meta')
    <meta content="{{ csrf_token() }}" name="token-csrf">
@endpush
@section('judul', 'Cabang')
@section('topbar', 'Cabang')
@section('konten')
    {{-- kartu --}}
    <div class="card my-4 shadow">
        <div class="card-body">
            <form name="edit-cabang">
                <div class="mb-3">
                    <label class="form-label" for="nama-cabang">Nama Cabang</label>
                    <input class="form-control" id="nama-cabang" name="nama-cabang" type="text" value="{{ $cabang->nama_cabang }}">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="alamat">Alamat</label>
                    <input class="form-control" id="alamat" name="alamat" type="text" value="{{ $cabang->alamat }}">
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
    <script src="{{ asset('js/master/cabang/edit.js') }}"></script>
@endpush
