<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Screen Vehicle Carousel</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body>

<div class="carousel" id="carousel"></div>

<script>
    const carousel = document.getElementById('carousel');
    let vehicles = [];
    let vehicleEls = [];
    let currentVehicleIndex = 0;

    (async function init() {
        try {
            vehicles = await fetchVehicles();
            console.log('vehicles: ', vehicles);
            if (!vehicles.length) {
                throw new Error('No vehicles found.');
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
        const url = 'https://argus.vicimus.com/tv/mym2G8X4g9/10';
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
        errorDiv.textContent = message;
        carousel.innerHTML = '';
        carousel.appendChild(errorDiv);
    }
</script>
</body>
</html>
<?php /**PATH /Users/michelbeaubien/www/tv-inventory/resources/views/welcome.blade.php ENDPATH**/ ?>