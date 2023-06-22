<nav class="bg-white navbar navbar-expand navbar-light shadow static-top topbar">
    <h5 class="fw-bold h5 ml-3 mt-2">@yield('topbar')</h5>
    <ul class="ml-auto navbar-nav">
        <div class="mr-2 profile">
            <img alt="Foto" class="img-profile rounded-circle" src="https://med.gov.bz/wp-content/uploads/2020/08/dummy-profile-pic.jpg" width="30">
            <span class="d-lg-inline d-none small">Ananda</span>
        </div>
        <a class="logout mt-1 text-decoration-none text-gray-600" href="{{ route('autentikasi.keluar') }}">
            <i class="fa-sign-out-alt fas"></i>
            <span>Keluar</span>
        </a>
    </ul>
</nav>
