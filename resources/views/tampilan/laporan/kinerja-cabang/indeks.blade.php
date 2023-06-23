@extends('struktur.dasar')
@section('judul', 'Kinerja Cabang')
@section('topbar', 'Kinerja Cabang')
@section('konten')
    {{-- kartu --}}
    <div class="card my-4 shadow">
        <form class="mt-3 mx-2 row">
            <div class="col-12 mb-3">
                <div class="input-group">
                    <input class="form-control" name="cabang" placeholder="Cari" type="text" value="{{ request()->query('cabang') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </div>
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
                        <th scope="col">Jumlah Transaksi</th>
                        <th scope="col">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($kinerja_cabang as $k)
                        <tr>
                            <td class="text-center">{{ $k->no }}</td>
                            <td>{{ $k->nama_cabang }}</td>
                            <td class="text-end">{{ $k->jumlah_transaksi }}</td>
                            <td class="text-end">{{ $k->total }}</td>
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
@push('js')
    <script src="{{ asset('js/laporan/kinerja-cabang/ekspor.js') }}"></script>
@endpush
