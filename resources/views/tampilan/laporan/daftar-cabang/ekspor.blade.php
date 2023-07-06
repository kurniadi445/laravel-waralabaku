@extends('struktur.pdf')
@section('judul', 'Daftar Cabang')
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
    <h4>Laporan Daftar Cabang</h4>
    <table>
        <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Cabang</th>
            <th scope="col">Alamat</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($daftar_cabang as $c)
            <tr>
                <td style="text-align: center">{{ $c->no }}</td>
                <td>{{ $c->nama_cabang }}</td>
                <td>{{ $c->alamat }}</td>
            </tr>
        @empty
            <tr style="text-align: center">
                <td colspan="3">Tidak ada data yang tersedia</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
