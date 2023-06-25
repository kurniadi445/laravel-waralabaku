@extends('struktur.dasar')
@section('judul', 'Dasbor')
@section('topbar', 'Dasbor')
@section('konten')
    <div class="py-4 row">
        <div class="col-xl-4 mb-3">
            {{-- kartu --}}
            <div class="border-left-primary card py-2 shadow">
                <div class="card-body">
                    <div class="align-items-center row">
                        <div class="col">
                            <div class="fw-bold mb-1 text-primary text-uppercase text-xs">Pendapatan Bulanan</div>
                            <div class="fw-bold h5 mb-0 text-gray-800">{{ $pendapatan_bulanan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-2x fa-calendar fas text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            {{-- kartu --}}
        </div>
        <div class="col-xl-4 mb-3">
            {{-- kartu --}}
            <div class="border-left-success card py-2 shadow">
                <div class="card-body">
                    <div class="align-items-center row">
                        <div class="col">
                            <div class="fw-bold mb-1 text-success text-uppercase text-xs">Pendapatan Harian</div>
                            <div class="fw-bold h5 mb-0 text-gray-800">{{ $pendapatan_harian }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-2x fa-dollar-sign fas text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            {{-- kartu --}}
        </div>
        <div class="col-xl-4 mb-3">
            {{-- kartu --}}
            <div class="border-left-info card py-2 shadow">
                <div class="card-body">
                    <div class="align-items-center row">
                        <div class="col">
                            <div class="fw-bold mb-1 text-info text-uppercase text-xs">Transaksi</div>
                            <div class="fw-bold h5 mb-0 text-gray-800">{{ $transaksi }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-2x fa-clipboard-list fas text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            {{-- kartu --}}
        </div>
        <div class="col-lg-7 col-xl-8 mb-3 mb-lg-0">
            {{-- kartu --}}
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="fw-bold mb-0 text-primary">Ringkasan Pendapatan</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="grafik-ringkasan-pendapatan"></canvas>
                    </div>
                </div>
            </div>
            {{-- kartu --}}
        </div>
        <div class="col-lg-5 col-xl-4">
            {{-- kartu --}}
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="fw-bold mb-0 text-primary">Sumber Pendapatan</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="grafik-sumber-pendapatan"></canvas>
                    </div>
                </div>
            </div>
            {{-- kartu --}}
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/dasbor/ringkasan-pendapatan.js') }}"></script>
    <script src="{{ asset('js/dasbor/sumber-pendapatan.js') }}"></script>
@endpush
