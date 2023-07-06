@extends('struktur.dasar')
@section('judul', 'Daftar Cabang')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" rel="stylesheet">
@endpush
@section('topbar', 'Daftar Cabang')
@section('konten')
    {{-- kartu --}}
    <div class="card my-4 shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-5">
                    {{-- kartu --}}
                    <div class="card">
                        <h5 class="card-header text-white" style="background-color: #0b2447">Informasi Cabang</h5>
                        <div class="card-body">
                            <h5 class="card-title">{{ $daftar_cabang->nama_cabang }}</h5>
                            <p class="card-text"><strong>Alamat</strong>: {{ $daftar_cabang->alamat }}</p>
                            <a class="btn btn-secondary" href="{{ route('laporan.daftar-cabang') }}">Kembali</a>
                        </div>
                    </div>
                    {{-- kartu --}}
                </div>
                <div class="col-xl-7">
                    <div class="border">
                        <div id="lokasi" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- kartu --}}
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <script src="{{ asset('js/laporan/daftar-cabang/lokasi.js') }}"></script>
@endpush
