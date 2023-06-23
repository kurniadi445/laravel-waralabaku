@extends('struktur.dasar')
@section('judul', 'Transaksi Penjualan')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
@endpush
@section('topbar', 'Transaksi Penjualan')
@section('konten')
    {{-- kartu --}}
    <div class="card my-4 shadow">
        <form class="mt-3 mx-2 row">
            <div class="col-md-6 col-sm-12 mb-2 mb-md-3">
                <label class="form-label" for="tanggal-mulai">Tanggal Mulai</label>
                <input class="datepicker form-control" id="tanggal-mulai" name="tanggal-mulai" placeholder="YYYY-MM-DD" type="text" value="{{ request()->query('tanggal-mulai') }}">
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label class="form-label">Tanggal Akhir</label>
                <input class="datepicker form-control" id="tanggal-mulai" name="tanggal-akhir" placeholder="YYYY-MM-DD" type="text" value="{{ request()->query('tanggal-akhir') }}">
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Filter</button>
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
                        <th scope="col">Total</th>
                        <th scope="col">Tanggal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($transaksi as $t)
                        <tr>
                            <td class="text-center">{{ $t->no }}</td>
                            <td class="text-end">{{ $t->total }}</td>
                            <td class="text-center">{{ $t->tanggal }}</td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="3">Tidak ada data yang tersedia</td>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/locales/bootstrap-datepicker.id.min.js"></script>
    <script src="{{ asset('js/laporan/transaksi-penjualan/indeks.js') }}"></script>
    <script src="{{ asset('js/laporan/transaksi-penjualan/ekspor.js') }}"></script>
@endpush
