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
                <div class="mb-3">
                    <button class="btn btn-info" id="tombol-connect-cabang" type="button">Connect Cabang</button>
                </div>
                <button class="btn btn-secondary" id="tombol-batal" type="button">Batal</button>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </form>
        </div>
    </div>
    {{-- kartu --}}
    {{-- modal --}}
    <div class="fade modal" id="modal-connect-cabang" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="fs-5 modal-title">Connect Cabang</h1>
                    <button class="btn-close" id="tombol-tutup" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            {{-- kartu --}}
                            <div class="card" id="kartu-cari-cabang">
                                <div class="card-header text-white" style="background-color: #0b2447"><i class="fa-magnifying-glass fas"></i> Cari Cabang</div>
                                <div class="card-body">
                                    <form name="cari-cabang">
                                        <div class="input-group">
                                            <input class="form-control" name="nama-cabang" placeholder="Nama cabang" type="text">
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
                                                <th scope="col">Nama Cabang</th>
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
    <script src="{{ asset('js/master/pengguna/tambah.js') }}"></script>
    <script src="{{ asset('js/master/pengguna/cari-cabang.js') }}"></script>
@endpush
