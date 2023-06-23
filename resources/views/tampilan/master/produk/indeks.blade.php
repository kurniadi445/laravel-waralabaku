@extends('struktur.dasar')
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
                                <span class="badge badge-warning"><a class="badge-link text-white" href="#">Edit</a></span>
                                <span class="badge badge-danger"><a class="badge-link text-white" href="#">Hapus</a></span>
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
@endsection
