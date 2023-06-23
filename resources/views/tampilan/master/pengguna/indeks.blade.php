@extends('struktur.dasar')
@section('judul', 'Pengguna')
@section('topbar', 'Pengguna')
@section('konten')
    <a class="btn btn-success my-4" href="#"><i class="fa-plus fas"></i> Tambah</a>
    {{-- kartu --}}
    <div class="card mb-4 shadow">
        <div class="card-body">
            {{-- tabel --}}
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">Level</th>
                        <th scope="col">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($pengguna as $p)
                        <tr>
                            <td class="text-center">{{ $p->no }}</td>
                            <td>{{ $p->nama_lengkap }}</td>
                            <td class="text-center">{{ $p->level }}</td>
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
