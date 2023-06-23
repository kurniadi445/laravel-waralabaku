@extends('struktur.dasar')
@push('meta')
    <meta content="{{ csrf_token() }}" name="token-csrf">
@endpush
@section('judul', 'Produk')
@section('topbar', 'Produk')
@section('konten')
    {{-- kartu --}}
    <div class="card my-4 shadow">
        <div class="card-body">
            <form name="edit-produk">
                <div class="mb-3">
                    <label class="form-label" for="nama-produk">Nama Produk</label>
                    <input class="form-control" id="nama-produk" name="nama-produk" type="text" value="{{ $produk->nama_produk }}">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="harga">Harga</label>
                    <input class="form-control" id="harga" name="harga" type="number" value="{{ $produk->harga }}">
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
    <script src="{{ asset('js/master/produk/edit.js') }}"></script>
@endpush
