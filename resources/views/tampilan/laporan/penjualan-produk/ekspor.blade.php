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
    <h4>Penjualan Produk</h4>
    <table>
        <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Produk</th>
            <th scope="col">Terjual</th>
            <th scope="col">Total</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($penjualan_produk as $p)
            <tr>
                <td style="text-align: center">{{ $p->no }}</td>
                <td>{{ $p->nama_produk }}</td>
                <td style="text-align: right">{{ $p->terjual }}</td>
                <td style="text-align: right">{{ $p->total }}</td>
            </tr>
        @empty
            <tr style="text-align: center">
                <td colspan="4">Tidak ada data yang tersedia</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
