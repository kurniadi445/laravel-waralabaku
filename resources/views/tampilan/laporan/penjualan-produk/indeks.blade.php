@extends('struktur.dasar')
@section('judul', 'Penjualan Produk')
@section('topbar', 'Penjualan Produk')
@section('konten')
    {{-- kartu --}}
    <div class="card my-4 shadow">
        <form class="mt-3 mx-2 row" name="urutan-terjual">
            <div class="col-12 mb-3">
                <label class="form-label" for="urutan-terjual">Urutan Terjual</label>
                <select class="form-select" id="urutan-terjual" name="urutan-terjual">
                    <option @if (!request()->query('urutan-terjual')) selected @endif>Pilih...</option>
                    <option @if (request()->query('urutan-terjual') === 'tertinggi') selected @endif value="tertinggi">Tertinggi</option>
                    <option @if (request()->query('urutan-terjual') === 'terendah') selected @endif value="terendah">Terendah</option>
                </select>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Filter</button>
                <button class="btn btn-success" id="tombol-ekspor" type="button">Ekspor</button>
            </div>
        </form>
        <form class="mt-3 mx-2 row" name="cari-produk">
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
                        <th scope="col">Terjual</th>
                        <th scope="col">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($penjualan_produk as $p)
                        <tr>
                            <td class="text-center">{{ $p->no }}</td>
                            <td>{{ $p->nama_produk }}</td>
                            <td class="text-end">{{ $p->terjual }}</td>
                            <td class="text-end">{{ $p->total }}</td>
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
    <script src="{{ asset('js/laporan/penjualan-produk/indeks.js') }}"></script>
@endpush
