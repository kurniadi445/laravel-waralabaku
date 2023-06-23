@extends('struktur.pdf')
@section('judul', 'Kinerja Cabang')
@push('css')
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #000000;
            padding: 5px;
        }
    </style>
@endpush
@section('konten')
    <h4>Laporan Kinerja Cabang</h4>
    <table>
        <thead>
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
                <td style="text-align: center">{{ $k->no }}</td>
                <td>{{ $k->nama_cabang }}</td>
                <td style="text-align: right">{{ $k->jumlah_transaksi }}</td>
                <td style="text-align: right">{{ $k->total }}</td>
            </tr>
        @empty
            <tr style="text-align: center">
                <td colspan="4">Tidak ada data yang tersedia</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
