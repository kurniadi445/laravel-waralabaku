@extends('struktur.dasar')
@push('meta')
    <meta content="{{ csrf_token() }}" name="token-csrf">
@endpush
@section('judul', 'Produk')
@section('topbar', 'Produk')
@section('konten')
    <a class="btn btn-success my-4" href="{{ route('master.produk.tambah') }}"><i class="fa-plus fas"></i> Tambah</a>
    {{-- kartu --}}
    <div class="card mb-4 shadow">
        <div class="card-body">
            {{-- tabel --}}
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($produk as $p)
                        <tr>
                            <td class="text-center">{{ $p->no }}</td>
                            <td>{{ $p->nama_produk }}</td>
                            <td class="text-end">{{ $p->harga }}</td>
                            <td class="text-center">
                                <span class="badge badge-warning"><a class="badge-link text-white" href="{{ route('master.produk.edit', ['uuid' => $p->uuid_teks]) }}">Edit</a></span>
                                <span class="badge badge-danger"><a class="badge-link text-white tombol-hapus" data-uuid="{{ $p->uuid_teks }}" href="#">Hapus</a></span>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="4">Tidak ada data yang tersedia</td>
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
    <div class="fade modal" id="modal-hapus-produk" tabindex="-1">
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
    <script src="{{ asset('js/master/produk/hapus.js') }}"></script>
@endpush
