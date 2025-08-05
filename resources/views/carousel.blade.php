@extends('layouts.app')

@section('carousel')
    <div class="carousel" id="carousel"></div>

    <script>
        const OEM_KEY = @json($oemKey);
        const carousel = document.getElementById('carousel');
        let vehicles = [];
        let vehicleEls = [];
        let currentVehicleIndex = 0;

        (async function init() {
            try {
                vehicles = await fetchVehicles();

                if (!vehicles.length) {
                    showError('No vehicles found.');
                    return;
                }

                preloadImages(vehicles);
                buildCarousel(vehicles);
                vehicleEls = document.querySelectorAll('.vehicle');
                startCarousel();
            } catch (err) {
                console.error('Failed to initialize carousel:', err);
                showError('Failed to load inventory.');
            }
        })();

        async function fetchVehicles() {
            const url = `https://argus.vicimus.com/tv/${OEM_KEY}/10`;
            const res = await fetch(url);
            if (!res.ok) {
                throw new Error(`API Error: ${res.status}`);
            }

            const raw = await res.json();
            const data = Object.values(raw);

            return Array.isArray(data) ? data : [];
        }

        function preloadImages(vehicles) {
            for (const vehicle of vehicles) {
                const img = new Image();
                img.src = vehicle.photos[0];
            }
        }

        function buildCarousel(vehicles) {
            for (const vehicle of vehicles) {
                const div = document.createElement('div');
                div.className = 'vehicle';
                div.innerHTML = `
            <img src="${vehicle.photos[0]}" alt="${vehicle.make} ${vehicle.model}" class="vehicle-image">
            <div class="vehicle-info">
                ${vehicle.year ?? ''} ${vehicle.make ?? ''} ${vehicle.model ?? ''}
            </div>
            <div class="price">${vehicle.price ?? ''}</div>
        `;
                carousel.appendChild(div);
            }
        }

        function showVehicle(index) {
            vehicleEls.forEach((el, i) => {
                const isActive = i === index;
                el.classList.toggle('active', isActive);

                if (isActive) {
                    const img = el.querySelector('img');
                    img.classList.remove('vehicle-image');
                    void img.offsetWidth;
                    img.classList.add('vehicle-image');
                }
            });
        }

        function nextVehicle() {
            currentVehicleIndex = (currentVehicleIndex + 1) % vehicleEls.length;
            showVehicle(currentVehicleIndex);
        }

        function startCarousel() {
            showVehicle(currentVehicleIndex);
            setInterval(nextVehicle, 5000);
        }

        function showError(message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'vehicle-error';

            const errorText = document.createElement('div');
            errorText.textContent = message;
            errorDiv.appendChild(errorText);

            carousel.innerHTML = '';
            carousel.appendChild(errorDiv);
        }
    </script>
@endsection
