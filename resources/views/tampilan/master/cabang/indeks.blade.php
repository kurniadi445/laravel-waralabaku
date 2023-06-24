@extends('struktur.dasar')
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
                        <th scope="col">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($cabang as $c)
                        <tr>
                            <td class="text-center">{{ $c->no }}</td>
                            <td>{{ $c->nama_cabang }}</td>
                            <td>{{ $c->alamat }}</td>
                            <td class="text-center">
                                <span class="badge badge-warning"><a class="badge-link text-white" href="{{ route('master.cabang.edit', ['uuid' => $c->uuid_teks]) }}">Edit</a></span>
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
