@extends('struktur.dasar')
@push('meta')
    <meta content="{{ csrf_token() }}" name="token-csrf">
@endpush
@section('judul', 'Stok')
@section('topbar', 'Stok')
@section('konten')
    {{-- kartu --}}
    <div class="card my-4 shadow">
        <form class="mt-3 mx-2 row">
            <div class="col-12">
                <div class="input-group">
                    <input class="form-control" name="cari" placeholder="Cari" type="text" value="{{ request()->query('cari') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </div>
        </form>
        <div class="card-body">
            {{-- tabel --}}
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($stok as $s)
                        <tr>
                            <td class="text-center">{{ $s->no }}</td>
                            <td>{{ $s->nama_produk }}</td>
                            <td class="text-end">{{ $s->stok }}</td>
                            <td class="text-center">
                                <span class="badge badge-warning"><a class="badge-link text-white tombol-edit" data-uuid="{{ $s->uuid_teks }}" href="#">Edit</a></span>
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
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="{{ asset('js/master/stok/edit.js') }}"></script>
@endpush
