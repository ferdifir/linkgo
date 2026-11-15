@php
    $villages = [
        ['name' => 'Banyuanyar Lor', 'slug' => 'banyuanyar-lor'],
        ['name' => 'Brumbungan Lor', 'slug' => 'brumbungan-lor'],
        ['name' => 'Bulang', 'slug' => 'bulang'],
        ['name' => 'Curahsawo', 'slug' => 'curahsawo'],
        ['name' => 'Gending', 'slug' => 'gending'],
        ['name' => 'Jatiadi', 'slug' => 'jatiadi'],
        ['name' => 'Klaseman', 'slug' => 'klaseman'],
        ['name' => 'Pajurangan', 'slug' => 'pajurangan'],
        ['name' => 'Pesisir', 'slug' => 'pesisir'],
        ['name' => 'Pikatan', 'slug' => 'pikatan'],
        ['name' => 'Randupitu', 'slug' => 'randupitu'],
        ['name' => 'Sebaung', 'slug' => 'sebaung'],
        ['name' => 'Sumberkerang', 'slug' => 'sumberkerang'],
    ];
@endphp
<!doctype html>
<html lang="id" data-page="village-directory">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#eff2eb">
    <meta name="description" content="LinkGo membantu Anda menjelajahi 13 desa di Kecamatan Gending melalui peta interaktif dan membuka laman informasi setiap desa.">
    <meta property="og:site_name" content="LinkGo">
    <meta property="og:title" content="LinkGo | Jelajahi Desa di Kecamatan Gending">
    <title>LinkGo | Jelajahi Desa di Kecamatan Gending</title>
    @include('desa.partials.favicon')
    @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/js/home-map.js'])
</head>
<body class="m-0 overflow-hidden font-sans antialiased">
    <main class="gending-map-page relative h-dvh min-h-[560px] w-screen overflow-hidden text-slate-950" aria-label="Peta desa Kecamatan Gending">
        <div id="village-map" class="absolute inset-0" role="application" aria-label="Peta interaktif 13 desa di Kecamatan Gending"></div>

        <header class="gending-map-brand absolute z-10 flex items-center gap-3">
            <span class="portal-village-logo" aria-hidden="true"><img src="{{ asset('images/portal-logo.png') }}" alt=""></span>
            <span class="gending-brand-copy">
                <strong>LinkGo</strong>
                <small>Kecamatan Gending · Probolinggo, Jawa Timur</small>
            </span>
        </header>

        <aside class="gending-map-panel absolute z-10 flex flex-col" aria-labelledby="directory-title">
            <div class="gending-panel-top flex items-center justify-between gap-4">
                <span class="gending-overline"><span aria-hidden="true"></span> Kecamatan Gending</span>
                <span class="gending-village-count">13 desa</span>
            </div>

            <aside class="gending-province-locator" aria-label="Lokasi Kecamatan Gending di Provinsi Jawa Timur">
                <div id="province-locator-map"></div>
                <span><small>PROVINSI</small><strong>Jawa Timur</strong></span>
            </aside>

            <div class="gending-intro">
                <h1 id="directory-title">Satu peta.<br><span>13 cerita desa.</span></h1>
                <p>Kenali 13 desa di Kecamatan Gending. Jalan dan batas wilayah membantu menemukan laman desa yang kamu cari.</p>
            </div>

            <form class="gending-search relative" role="search" autocomplete="off" onsubmit="return false">
                <label for="village-search">Cari desa</label>
                <div class="gending-search-field flex items-center gap-3">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 4.5 4.5"/></svg>
                    <input id="village-search" name="village" type="search" placeholder="Contoh: Sebaung" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="village-suggestions">
                    <button id="clear-search" class="gending-clear-search" type="button" aria-label="Hapus pencarian" hidden>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg>
                    </button>
                </div>
                <ul id="village-suggestions" class="gending-suggestions" role="listbox" aria-label="Hasil pencarian desa" hidden>
                    @foreach ($villages as $village)
                        <li role="option" data-village-option data-name="{{ $village['name'] }}" data-slug="{{ $village['slug'] }}">
                            <a href="{{ route('village.show', ['slug' => $village['slug']]) }}" tabindex="-1">
                                <span>{{ $village['name'] }}</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </a>
                        </li>
                    @endforeach
                    <li class="gending-no-results" id="village-no-results" hidden role="presentation">Desa tidak ditemukan.</li>
                </ul>
            </form>

            <section id="village-preview" class="gending-preview" aria-live="polite" aria-atomic="true">
                <span class="gending-preview-index">PETA WILAYAH</span>
                <h2 id="preview-title">Pilih satu desa</h2>
                <p id="preview-copy">Klik wilayah berwarna untuk membuka situs desa. Inset menunjukkan posisi Gending di Jawa Timur.</p>
                <a id="preview-link" class="gending-preview-link" href="#" hidden>
                    <span>Buka situs desa</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </a>
            </section>

            <div class="gending-panel-foot flex items-center justify-between gap-3">
                <span class="gending-source-links">
                    <a href="https://geoservices.big.go.id/rbi/rest/services/BATASWILAYAH/Administrasi_AR_KelDesa_10K/MapServer" target="_blank" rel="noopener noreferrer">Batas desa · BIG</a>
                    <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer">© OpenStreetMap</a>
                </span>
            </div>
        </aside>

        <div class="gending-map-controls absolute z-10 flex flex-col gap-2" aria-label="Kontrol peta">
            <button id="zoom-in" type="button" aria-label="Perbesar peta"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg></button>
            <button id="zoom-out" type="button" aria-label="Perkecil peta"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M5 12h14"/></svg></button>
            <button id="reset-map" type="button" aria-label="Tampilkan semua desa"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11a9 9 0 1 1 2.6 6.4M3 4v7h7"/><path d="M12 7v5l3 2"/></svg></button>
        </div>

        <div class="gending-map-message absolute z-10" id="map-message" role="status" aria-live="polite" hidden></div>
    </main>
</body>
</html>
