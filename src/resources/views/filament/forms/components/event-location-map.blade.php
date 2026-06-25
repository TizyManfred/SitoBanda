<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        wire:ignore
        x-data="eventLocationMap()"
        x-init="init()"
        class="space-y-2"
    >
        @once
            <link
                rel="stylesheet"
                href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
                crossorigin=""
            />
            <script
                src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                crossorigin=""
            ></script>
        @endonce

        <div class="text-sm text-gray-600">
            Clicca sulla mappa o trascina il marker per aggiornare latitudine e longitudine.
        </div>

        <div
            x-ref="map"
            style="height: 320px; width: 100%; border-radius: 0.75rem; overflow: hidden;"
        ></div>
    </div>
</x-dynamic-component>

<script>
    function eventLocationMap() {
        return {
            map: null,
            marker: null,
            defaultCenter: [46.0703, 11.6417],

            init() {
                const boot = () => {
                    const latitudeInput = document.querySelector('input[wire\\:model$=".latitude"]');
                    const longitudeInput = document.querySelector('input[wire\\:model$=".longitude"]');

                    if (! latitudeInput || ! longitudeInput) {
                        return;
                    }

                    const latitude = parseFloat(latitudeInput.value);
                    const longitude = parseFloat(longitudeInput.value);
                    const initialCenter = Number.isFinite(latitude) && Number.isFinite(longitude)
                        ? [latitude, longitude]
                        : this.defaultCenter;

                    this.map = L.map(this.$refs.map).setView(initialCenter, Number.isFinite(latitude) && Number.isFinite(longitude) ? 15 : 11);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors',
                    }).addTo(this.map);

                    this.marker = L.marker(initialCenter, {
                        draggable: true,
                    }).addTo(this.map);

                    const updateInputs = (latlng) => {
                        latitudeInput.value = latlng.lat.toFixed(6);
                        longitudeInput.value = latlng.lng.toFixed(6);

                        latitudeInput.dispatchEvent(new Event('input', { bubbles: true }));
                        longitudeInput.dispatchEvent(new Event('input', { bubbles: true }));
                    };

                    this.map.on('click', (event) => {
                        this.marker.setLatLng(event.latlng);
                        updateInputs(event.latlng);
                    });

                    this.marker.on('dragend', () => {
                        updateInputs(this.marker.getLatLng());
                    });

                    const syncMarkerFromInputs = () => {
                        const inputLat = parseFloat(latitudeInput.value);
                        const inputLng = parseFloat(longitudeInput.value);

                        if (! Number.isFinite(inputLat) || ! Number.isFinite(inputLng)) {
                            return;
                        }

                        const latlng = L.latLng(inputLat, inputLng);
                        this.marker.setLatLng(latlng);
                        this.map.panTo(latlng);
                    };

                    latitudeInput.addEventListener('change', syncMarkerFromInputs);
                    longitudeInput.addEventListener('change', syncMarkerFromInputs);

                    setTimeout(() => {
                        this.map.invalidateSize();
                    }, 200);
                };

                if (window.L) {
                    boot();
                    return;
                }

                const waitForLeaflet = window.setInterval(() => {
                    if (! window.L) {
                        return;
                    }

                    window.clearInterval(waitForLeaflet);
                    boot();
                }, 100);
            },
        };
    }
</script>
