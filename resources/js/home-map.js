import { AttributionControl, Map, ScaleControl, setWorkerUrl } from 'maplibre-gl';

setWorkerUrl(new URL('maplibre-gl/dist/maplibre-gl-worker.mjs', import.meta.url).toString());

const mapElement = document.getElementById('village-map');
const searchInput = document.getElementById('village-search');
const suggestions = document.getElementById('village-suggestions');
const noResults = document.getElementById('village-no-results');
const clearSearchButton = document.getElementById('clear-search');
const preview = document.getElementById('village-preview');
const previewTitle = document.getElementById('preview-title');
const previewCopy = document.getElementById('preview-copy');
const previewLink = document.getElementById('preview-link');
const message = document.getElementById('map-message');

const villageOptions = [...document.querySelectorAll('[data-village-option]')];
const mobileViewport = window.matchMedia('(max-width: 760px)');
const gendingCenter = [113.309714, -7.792714];
const desktopPadding = { top: 104, right: 96, bottom: 96, left: 480 };

let mapData = null;
let activeFeatureId = null;
let previousHoverId = null;
let fallbackActivated = false;
let fallbackTimer = window.setTimeout(() => {
    if (!mapData && !fallbackActivated) {
        fallbackActivated = true;
        map.setStyle({
            version: 8,
            sources: {},
            layers: [{ id: 'background', type: 'background', paint: { 'background-color': '#e7eeeb' } }],
        });
    }
}, 8000);
let loadingTimer = window.setTimeout(() => {
    showMapMessage('Peta sedang memuat. Pastikan koneksi internet tersedia.');
}, 12000);

const map = new Map({
    container: mapElement,
    style: 'https://tiles.openfreemap.org/styles/positron',
    center: gendingCenter,
    zoom: 10.5,
    minZoom: 9,
    maxZoom: 16,
    maxPitch: 0,
    attributionControl: false,
    cooperativeGestures: true,
    dragRotate: false,
    pitchWithRotate: false,
    touchPitch: false,
    boxZoom: false,
    fadeDuration: 120,
    canvasContextAttributes: { antialias: true },
});
map.addControl(new AttributionControl({
    compact: true,
    customAttribution: '<a href="https://geoservices.big.go.id/rbi/rest/services/BATASWILAYAH/Administrasi_AR_KelDesa_10K/MapServer" target="_blank" rel="noopener noreferrer">Batas desa: BIG</a>',
}), 'bottom-right');
map.addControl(new ScaleControl({ maxWidth: 100, unit: 'metric' }), 'bottom-right');
map.on('error', () => {
    if (!mapData && !fallbackActivated) {
        fallbackActivated = true;
        window.clearTimeout(fallbackTimer);
        map.setStyle({
            version: 8,
            sources: {},
            layers: [{ id: 'background', type: 'background', paint: { 'background-color': '#e7eeeb' } }],
        });
    }
});

map.on('load', async () => {
    try {
        const [provinceResponse, villageResponse, roadsResponse] = await Promise.all([
            fetch('/data/jawa-timur.geojson', { headers: { Accept: 'application/geo+json, application/json' } }),
            fetch('/data/gending-villages.geojson', { headers: { Accept: 'application/geo+json, application/json' } }),
            fetch('/data/gending-roads.geojson', { headers: { Accept: 'application/geo+json, application/json' } }),
        ]);

        if (!provinceResponse.ok || !villageResponse.ok || !roadsResponse.ok) {
            throw new Error('GeoJSON wilayah tidak dapat dimuat.');
        }

        const provinceData = await provinceResponse.json();
        const roadsData = await roadsResponse.json();
        mapData = await villageResponse.json();
        addVillageLayers(mapData);
        addRoadLayers(roadsData);
        addProvinceInset(provinceData);
        fitAllVillages(false);
        window.clearTimeout(fallbackTimer);
        window.clearTimeout(loadingTimer);
        message.hidden = true;
    } catch (error) {
        window.clearTimeout(loadingTimer);
        showMapMessage('Peta wilayah belum dapat dimuat. Silakan muat ulang halaman.');
        console.error(error);
    }
});

document.getElementById('zoom-in').addEventListener('click', () => map.zoomIn({ duration: 250 }));
document.getElementById('zoom-out').addEventListener('click', () => map.zoomOut({ duration: 250 }));
document.getElementById('reset-map').addEventListener('click', () => fitAllVillages(true));

searchInput.addEventListener('input', () => {
    clearSearchButton.hidden = searchInput.value.trim() === '';
    setSuggestionsOpen(true);
    filterVillages(searchInput.value);
});

searchInput.addEventListener('focus', () => {
    filterVillages(searchInput.value);
    setSuggestionsOpen(true);
});

searchInput.addEventListener('keydown', (event) => {
    if (event.key === 'ArrowDown' && !suggestions.hidden) {
        event.preventDefault();
        villageOptions.find((option) => !option.hidden)?.querySelector('a')?.focus();
    }

    if (event.key === 'Escape') {
        setSuggestionsOpen(false);
    }

    if (event.key === 'Enter') {
        const firstMatch = villageOptions.find((option) => !option.hidden)?.querySelector('a');
        if (firstMatch) {
            event.preventDefault();
            window.location.assign(firstMatch.href);
        }
    }
});

clearSearchButton.addEventListener('click', () => {
    searchInput.value = '';
    clearSearchButton.hidden = true;
    setSuggestionsOpen(false);
    searchInput.focus();
    villageOptions.forEach((option) => setOptionHighlight(option.dataset.slug, false));
});

document.addEventListener('pointerdown', (event) => {
    if (!event.target.closest('.gending-search')) {
        setSuggestionsOpen(false);
    }
});

function addVillageLayers(data) {
    map.addSource('village-polygons', {
        type: 'geojson',
        data,
        promoteId: 'slug',
        buffer: 128,
        tolerance: 0.25,
    });

    map.addLayer({
        id: 'village-fill',
        type: 'fill',
        source: 'village-polygons',
        paint: {
            'fill-color': [
                'case',
                ['boolean', ['feature-state', 'selected'], false], '#db805a',
                ['boolean', ['feature-state', 'hover'], false], '#e4b781',
                '#cbdcc7',
            ],
            'fill-opacity': [
                'case',
                ['boolean', ['feature-state', 'selected'], false], 0.84,
                ['boolean', ['feature-state', 'hover'], false], 0.76,
                0.52,
            ],
        },
    });

    map.addLayer({
        id: 'village-outline',
        type: 'line',
        source: 'village-polygons',
        paint: {
            'line-color': [
                'case',
                ['boolean', ['feature-state', 'selected'], false], '#a9583e',
                ['boolean', ['feature-state', 'hover'], false], '#aa7952',
                '#698775',
            ],
            'line-width': [
                'case',
                ['boolean', ['feature-state', 'selected'], false], 2.6,
                ['boolean', ['feature-state', 'hover'], false], 2.2,
                1.25,
            ],
            'line-opacity': 0.95,
        },
    });

    map.on('mousemove', 'village-fill', (event) => {
        const feature = event.features?.[0];
        if (!feature) {
            return;
        }

        map.getCanvas().style.cursor = 'pointer';
        updateHoverState(feature.id);
        showVillagePreview(feature.properties);
    });

    map.on('mouseleave', 'village-fill', () => {
        map.getCanvas().style.cursor = '';
        if (previousHoverId !== null) {
            map.setFeatureState({ source: 'village-polygons', id: previousHoverId }, { hover: false });
            previousHoverId = null;
        }

        if (activeFeatureId === null) {
            resetVillagePreview();
        }
    });

    map.on('click', 'village-fill', (event) => {
        const feature = event.features?.[0];
        if (feature?.properties?.url) {
            if (mobileViewport.matches) {
                window.location.assign(feature.properties.url);
            } else {
                showVillagePreview(feature.properties);
            }
        }
    });
}

function addRoadLayers(data) {
    map.addSource('gending-roads', { type: 'geojson', data, tolerance: 0.25 });
    map.addLayer({
        id: 'gending-road-lines',
        type: 'line',
        source: 'gending-roads',
        layout: { 'line-cap': 'round', 'line-join': 'round' },
        paint: {
            'line-color': '#9aa9a1',
            'line-width': ['interpolate', ['linear'], ['zoom'], 10, 0.45, 13, 0.95, 16, 1.8],
            'line-opacity': 0.72,
        },
    });
}

function addProvinceInset(data) {
    const container = document.getElementById('province-locator-map');
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    const provinceGeometry = data.features[0].geometry;
    const points = collectCoordinates(provinceGeometry.coordinates);
    const west = Math.min(...points.map(([longitude]) => longitude));
    const east = Math.max(...points.map(([longitude]) => longitude));
    const south = Math.min(...points.map(([, latitude]) => latitude));
    const north = Math.max(...points.map(([, latitude]) => latitude));
    const toSvgPoint = ([longitude, latitude]) => [
        5 + ((longitude - west) / (east - west)) * 150,
        5 + ((north - latitude) / (north - south)) * 100,
    ];
    const rings = provinceGeometry.coordinates.flatMap((polygon) => polygon);
    const pathData = rings.map((ring) => ring.map((point, index) => {
        const [x, y] = toSvgPoint(point);
        return `${index === 0 ? 'M' : 'L'}${x.toFixed(2)},${y.toFixed(2)}`;
    }).join(' ') + ' Z').join(' ');
    const provinceShape = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    provinceShape.setAttribute('d', pathData);
    provinceShape.setAttribute('class', 'gending-province-shape');
    provinceShape.setAttribute('fill-rule', 'evenodd');
    svg.setAttribute('viewBox', '0 0 160 110');
    svg.setAttribute('role', 'img');
    svg.setAttribute('aria-label', 'Peta Provinsi Jawa Timur dengan penanda Kecamatan Gending');
    svg.append(provinceShape);

    const [markerX, markerY] = toSvgPoint([113.31742, -7.797]);
    const markerRing = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    markerRing.setAttribute('cx', markerX.toFixed(2));
    markerRing.setAttribute('cy', markerY.toFixed(2));
    markerRing.setAttribute('r', '5.5');
    markerRing.setAttribute('class', 'gending-province-marker-ring');
    const marker = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    marker.setAttribute('cx', markerX.toFixed(2));
    marker.setAttribute('cy', markerY.toFixed(2));
    marker.setAttribute('r', '2.7');
    marker.setAttribute('class', 'gending-province-marker');
    svg.append(markerRing, marker);
    container.replaceChildren(svg);
}

function fitAllVillages(animate) {
    if (!mapData) {
        return;
    }

    const points = mapData.features.flatMap((feature) => collectCoordinates(feature.geometry.coordinates));
    const west = Math.min(...points.map(([longitude]) => longitude));
    const east = Math.max(...points.map(([longitude]) => longitude));
    const south = Math.min(...points.map(([, latitude]) => latitude));
    const north = Math.max(...points.map(([, latitude]) => latitude));

    const longitudePadding = (east - west) * 0.1;
    const latitudePadding = (north - south) * 0.1;
    const bounds = [
        [west - longitudePadding, south - latitudePadding],
        [east + longitudePadding, north + latitudePadding],
    ];
    const padding = mobileViewport.matches
        ? { top: 80, right: 32, bottom: Math.min(window.innerHeight * 0.52, 405), left: 32 }
        : desktopPadding;
    const fittedCamera = map.cameraForBounds(bounds, { padding, absolutePadding: true });
    const fittedZoom = fittedCamera.zoom;

    map.setMinZoom(fittedZoom);
    map.fitBounds(bounds, {
        padding,
        absolutePadding: true,
        maxZoom: fittedZoom,
        duration: animate ? 650 : 0,
        linear: !animate,
    });
}

function collectCoordinates(coordinates) {
    if (typeof coordinates[0] === 'number' && typeof coordinates[1] === 'number') {
        return [[coordinates[0], coordinates[1]]];
    }

    return coordinates.flatMap(collectCoordinates);
}

function updateHoverState(featureId) {
    if (previousHoverId !== null && previousHoverId !== featureId) {
        map.setFeatureState({ source: 'village-polygons', id: previousHoverId }, { hover: false });
    }

    previousHoverId = featureId;
    map.setFeatureState({ source: 'village-polygons', id: featureId }, { hover: true });
}

function showVillagePreview(properties) {
    activeFeatureId = properties.slug;
    villageOptions.forEach((option) => setOptionHighlight(option.dataset.slug, option.dataset.slug === properties.slug));
    preview.classList.add('is-active');
    previewTitle.textContent = properties.name;
    previewCopy.textContent = `Lihat informasi, layanan, dan kabar terbaru Desa ${properties.name}.`;
    previewLink.href = properties.url;
    previewLink.hidden = false;
}

function resetVillagePreview() {
    activeFeatureId = null;
    villageOptions.forEach((option) => setOptionHighlight(option.dataset.slug, false));
    preview.classList.remove('is-active');
    previewTitle.textContent = 'Pilih satu desa';
    previewCopy.textContent = 'Klik wilayah berwarna untuk membuka situs desa. Perkecil peta untuk melihat posisi Gending di Jawa Timur.';
    previewLink.hidden = true;
    previewLink.removeAttribute('href');
}

function setOptionHighlight(slug, isActive) {
    const option = villageOptions.find((candidate) => candidate.dataset.slug === slug);
    option?.classList.toggle('is-highlighted', isActive);

    if (map.getSource('village-polygons')) {
        map.setFeatureState({ source: 'village-polygons', id: slug }, { search: isActive });
    }
}

function setSuggestionsOpen(isOpen) {
    suggestions.hidden = !isOpen;
    searchInput.setAttribute('aria-expanded', String(isOpen));
}

function filterVillages(query) {
    const normalizedQuery = query.trim().toLocaleLowerCase('id');
    let visibleOptions = 0;

    villageOptions.forEach((option) => {
        const matches = option.dataset.name.toLocaleLowerCase('id').includes(normalizedQuery);
        option.hidden = !matches;
        visibleOptions += Number(matches);
        setOptionHighlight(option.dataset.slug, false);
    });

    noResults.hidden = visibleOptions !== 0;
}

function showMapMessage(text) {
    message.textContent = text;
    message.hidden = false;
}

window.addEventListener('resize', () => {
    if (mapData) {
        fitAllVillages(false);
    }
});

mobileViewport.addEventListener('change', () => {
    if (mapData) {
        fitAllVillages(false);
    }
});
