<ul class="accordion navbar-nav sidebar sidebar-dark" id="accordionSidebar" style="background-color: #0b2447">
    {{-- merek --}}
    <a class="align-items-center d-flex justify-content-center sidebar-brand">
        <div class="rotate-n-15 sidebar-brand-icon">
            <i class="fa-laugh-wink fas"></i>
        </div>
        <div class="mx-3 sidebar-brand-text">{{ config('app.name') }}</div>
    </a>
    {{-- merek --}}
    {{-- pembatas --}}
    <hr class="sidebar-divider">
    {{-- pembatas --}}
    {{-- heading --}}
    <div class="sidebar-heading">Dasbor</div>
    {{-- heading --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dasbor') }}">
            <i class="fa-tachometer-alt fas"></i>
            <span>Dasbor</span>
        </a>
    </li>
    {{-- pembatas --}}
    <hr class="sidebar-divider">
    {{-- pembatas --}}
    {{-- heading --}}
    <div class="sidebar-heading">Master</div>
    {{-- heading --}}
    @if ($level === 'Admin')
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa-shop fas"></i>
                <span>Cabang</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('master.produk') }}">
                <i class="fa-box fas"></i>
                <span>Produk</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa-user fas"></i>
                <span>Pengguna</span>
            </a>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link" href="{{ route('master.stok') }}">
                <i class="fa-box fas"></i>
                <span>Stok</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa-money-bill-alt far"></i>
                <span>Transaksi</span>
            </a>
        </li>
    @endif
    {{-- pembatas --}}
    <hr class="sidebar-divider">
    {{-- pembatas --}}
    {{-- heading --}}
    <div class="sidebar-heading">Laporan</div>
    {{-- heading --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('laporan.transaksi-penjualan') }}">
            <i class="fa-shop fas"></i>
            <span>Transaksi Penjualan</span>
        </a>
    </li>
    @if ($level === 'Admin')
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa-money-bill-alt far"></i>
                <span>Kinerja Cabang</span>
            </a>
        </li>
    @endif
</ul>
