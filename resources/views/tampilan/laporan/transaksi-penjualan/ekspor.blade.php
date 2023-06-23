@extends('struktur.pdf')
@section('judul', 'Transaksi Penjualan')
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
    <h4>Laporan Transaksi Penjualan</h4>
    @if (request()->query('tanggal-mulai') && request()->query('tanggal-akhir'))
        <p>Periode: {{ request()->query('tanggal-mulai') }} sampai {{ request()->query('tanggal-akhir') }}</p>
    @endif
    <table>
        <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Total</th>
            <th scope="col">Tanggal</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($transaksi as $t)
            <tr>
                <td style="text-align: center">{{ $t->no }}</td>
                <td style="text-align: right">{{ $t->total }}</td>
                <td style="text-align: center">{{ $t->tanggal }}</td>
            </tr>
        @empty
            <tr style="text-align: center">
                <td colspan="3">Tidak ada data yang tersedia</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
