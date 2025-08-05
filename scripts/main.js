const vehicles = [
    {
        year: 2021,
        make: 'Toyota',
        model: 'RAV4',
        price: '$28,995',
        photo: 'https://placehold.co/1200x675?text=RAV4'
    },
    {
        year: 2020,
        make: 'Honda',
        model: 'Civic',
        price: '$19,495',
        photo: 'https://placehold.co/1200x675?text=Civic'
    },
    {
        year: 2019,
        make: 'Ford',
        model: 'Escape',
        price: '$17,995',
        photo: 'https://placehold.co/1200x675?text=Escape'
    },
    {
        year: 2022,
        make: 'Chevrolet',
        model: 'Malibu',
        price: '$24,995',
        photo: 'https://placehold.co/1200x675?text=Malibu'
    },
    {
        year: 2018,
        make: 'Nissan',
        model: 'Altima',
        price: '$15,995',
        photo: 'https://placehold.co/1200x675?text=Altima'
    },
    {
        year: 2020,
        make: 'Hyundai',
        model: 'Elantra',
        price: '$18,995',
        photo: 'https://placehold.co/1200x675?text=Elantra'
    },
    {
        year: 2021,
        make: 'Kia',
        model: 'Sportage',
        price: '$22,995',
        photo: 'https://placehold.co/1200x675?text=Sportage'
    },
    {
        year: 2019,
        make: 'Mazda',
        model: 'CX-5',
        price: '$20,995',
        photo: 'https://placehold.co/1200x675?text=CX-5'
    },
    {
        year: 2022,
        make: 'Volkswagen',
        model: 'Jetta',
        price: '$23,495',
        photo: 'https://placehold.co/1200x675?text=Jetta'
    },
    {
        year: 2023,
        make: 'Subaru',
        model: 'Outback',
        price: '$27,995',
        photo: 'https://placehold.co/1200x675?text=Outback'
    }
];

const carousel = document.getElementById('carousel');

// Preload images
vehicles.forEach(vehicle => {
    const img = new Image();
    img.src = vehicle.photo;
});

// Create DOM elements
vehicles.forEach(vehicle => {
    const div = document.createElement('div');
    div.className = 'vehicle';
    div.innerHTML = `
        <img src='${vehicle.photo}' alt='${vehicle.make} ${vehicle.model}' class='vehicle-image'>
        <div class='vehicle-info'>
          ${vehicle.year} ${vehicle.make} ${vehicle.model}
        </div>
        <div class='price'>${vehicle.price}</div>
    `;
    carousel.appendChild(div);
});

let currentVehicleIndex = 0;
const vehicleEls = document.querySelectorAll('.vehicle');

function showVehicle(index) {
    vehicleEls.forEach((el, i) => {
        el.classList.toggle('active', i === index);

        if (i === index) {
            const img = el.querySelector('.vehicle-image');

            // Restart animation
            img.classList.remove('vehicle-image');
            void img.offsetWidth;
            img.classList.add('vehicle-image');
        }
    });
}

function nextVehicle() {
    currentVehicleIndex = (currentVehicleIndex + 1) % vehicles.length;
    showVehicle(currentVehicleIndex);
}

// Initialize
showVehicle(currentVehicleIndex);
setInterval(nextVehicle, 5000);
