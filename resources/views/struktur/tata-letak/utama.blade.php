{{-- pembungkus laman --}}
<div id="wrapper">
    {{-- sidebar --}}
    @include('struktur.komponen.sidebar')
    {{-- sidebar --}}
    {{-- pembungkus konten --}}
    <div class="d-flex flex-column" id="content-wrapper">
        {{-- konten utama --}}
        <div id="content">
            {{-- topbar --}}
            @include('struktur.komponen.topbar')
            {{-- topbar --}}
            <div class="container">
                @yield('konten')
            </div>
        </div>
        {{-- konten utama --}}
    </div>
    {{-- pembungkus konten --}}
</div>
{{-- pembungkus laman --}}
