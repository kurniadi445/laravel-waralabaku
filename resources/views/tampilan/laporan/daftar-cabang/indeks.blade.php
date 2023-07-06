@extends('struktur.dasar')
@section('judul', 'Daftar Cabang')
@section('topbar', 'Daftar Cabang')
@section('konten')
    {{-- kartu --}}
    <div class="card my-4 shadow">
        <form class="mt-3 mx-2 row">
            <div class="col-12">
                <button class="btn btn-success" id="tombol-ekspor" type="button">Ekspor</button>
            </div>
        </form>
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
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($daftar_cabang as $d)
                        <tr>
                            <td class="text-center">{{ $d->no }}</td>
                            <td>{{ $d->nama_cabang }}</td>
                            <td>{{ $d->alamat }}</td>
                            <td class="text-center"><a class="btn btn-outline-secondary btn-sm" href="#">Cek</a></td>
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
