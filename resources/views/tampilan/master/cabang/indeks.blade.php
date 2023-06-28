@extends('struktur.dasar')
@push('meta')
    <meta content="{{ csrf_token() }}" name="token-csrf">
@endpush
@section('judul', 'Cabang')
@section('topbar', 'Cabang')
@section('konten')
    <a class="btn btn-success my-4" href="{{ route('master.cabang.tambah') }}"><i class="fa-plus fas"></i> Tambah</a>
    {{-- kartu --}}
    <div class="card mb-4 shadow">
        <div class="card-body">
            {{-- tabel --}}
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Cabang</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($cabang as $c)
                        <tr>
                            <td class="text-center">{{ $c->no }}</td>
                            <td>{{ $c->nama_cabang }}</td>
                            <td>{{ $c->alamat }}</td>
                            <td class="text-center"><a class="btn btn-outline-secondary btn-sm" href="{{ route('master.cabang.lokasi', ['uuid' => $c->uuid_teks]) }}">Cek</a></td>
                            <td class="text-center">
                                <span class="badge badge-warning"><a class="badge-link text-white" href="{{ route('master.cabang.edit', ['uuid' => $c->uuid_teks]) }}">Edit</a></span>
                                <span class="badge badge-danger"><a class="badge-link text-white tombol-hapus" data-uuid="{{ $c->uuid_teks }}" href="#">Hapus</a></span>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="5">Tidak ada data yang tersedia</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{-- tabel --}}
        </div>
    </div>
    {{-- kartu --}}
    {{-- modal --}}
    <div class="fade modal" id="modal-hapus-cabang" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Anda yakin?</h5>
                </div>
                <div class="modal-body" id="badan-modal">
                    <p>Anda yakin ingin menghapus <strong></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark" id="tombol-tutup" type="button">Tutup</button>
                    <button class="btn btn-danger" id="tombol-yakin" type="button">Yakin</button>
                </div>
            </div>
        </div>
    </div>
    {{-- modal --}}
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="{{ asset('js/master/cabang/hapus.js') }}"></script>
@endpush
