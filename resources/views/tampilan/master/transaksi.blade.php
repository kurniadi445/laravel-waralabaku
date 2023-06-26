@extends('struktur.dasar')
@push('meta')
    <meta content="{{ csrf_token() }}" name="token-csrf">
@endpush
@section('judul', 'Transaksi')
@section('topbar', 'Transaksi')
@section('konten')
    {{-- kartu --}}
    <div class="card my-4 shadow">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    {{-- kartu --}}
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #0b2447">Detail Transaksi</div>
                        <div class="card-body">
                            <button class="btn btn-success mb-3" id="tombol-cari-produk" type="button"><i class="fa-magnifying-glass fas"></i> Cari Produk</button>
                            {{-- tabel --}}
                            <table class="table table-bordered" id="tabel-detail-transaksi">
                                <thead class="bg-dark text-center">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Kuantitas</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            {{-- tabel --}}
                            <div class="row">
                                <div class="col-4 offset-8">
                                    {{-- tabel --}}
                                    <table class="mb-0 table table-borderless">
                                        <tr>
                                            <td class="align-middle text-end">Total</td>
                                            <td class="align-middle text-center">:</td>
                                            <td><input class="form-control" disabled name="total" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-end" colspan="3">
                                                <button class="btn btn-success" id="tombol-bayar" type="button">Bayar</button>
                                                <button class="btn btn-danger" type="reset">Batal</button>
                                            </td>
                                        </tr>
                                    </table>
                                    {{-- tabel --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- kartu --}}
                </div>
            </div>
        </div>
    </div>
    {{-- kartu --}}
    {{-- modal --}}
    <div class="fade modal" id="modal-cari-produk" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="fs-5 modal-title">Produk</h1>
                    <button class="btn-close" id="tombol-tutup" type="button"></button>
                </div>
                <div class="modal-body" id="badan-modal">
                    <div class="row">
                        <div class="col-12">
                            {{-- kartu --}}
                            <div class="card" id="kartu-cari-produk">
                                <div class="card-header text-white" style="background-color: #0b2447"><i class="fa-magnifying-glass fas"></i> Cari Produk</div>
                                <div class="card-body">
                                    <form name="cari-produk">
                                        <div class="input-group">
                                            <input class="form-control" name="nama-produk" placeholder="Nama produk" type="text">
                                            <button class="btn btn-primary" type="submit">Cari</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- kartu --}}
                        </div>
                        <div class="col-12 d-none">
                            {{-- kartu --}}
                            <div class="card" id="kartu-hasil-pencarian">
                                <div class="card-header text-white" style="background-color: #0b2447">Hasil Pencarian</div>
                                <div class="card-body">
                                    {{-- tabel --}}
                                    <div class="mb-0 table table-responsive">
                                        <table class="mb-0 table table-bordered" id="tabel-hasil-pencarian">
                                            <thead class="text-center">
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Produk</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    {{-- tabel --}}
                                </div>
                            </div>
                            {{-- kartu --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal --}}
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="{{ asset('js/master/transaksi/indeks.js') }}"></script>
    <script src="{{ asset('js/master/transaksi/cari-produk.js') }}"></script>
    <script src="{{ asset('js/master/transaksi/bayar.js') }}"></script>
@endpush
