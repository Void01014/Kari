let currentListingPrice = 0;
let checkIn_pickr, checkOut_pickr;

function showMainContent() {
    const mainContent = document.getElementById('modalMainContent');
    const bookingForm = document.getElementById('bookingForm');
    if (mainContent && bookingForm) {
        mainContent.classList.remove('hidden');
        bookingForm.classList.add('hidden');
    }
}

function updateDisabledDates(currentId) {
    // Only run if both variables exist AND flatpickr is loaded
    if (typeof disabled_dates_objects !== 'undefined' && checkIn_pickr && checkOut_pickr) {
        let disabled_dates_temp = [];
        disabled_dates_objects.forEach(item => {
            if (String(item.id) === String(currentId)) {
                disabled_dates_temp.push({ from: item.dates[0], to: item.dates[1] });
            }
        });
        checkIn_pickr.set("disable", disabled_dates_temp);
        checkOut_pickr.set("disable", disabled_dates_temp);
    }
}

function openModal(listing) {
    const modal = document.getElementById('listingModal');
    if (!modal) return;

    showMainContent();
    updateDisabledDates(listing.id);

    document.getElementById('modalImage').innerHTML = listing.image ?
        `<img src="public/uploads/${listing.image}" alt="${listing.title}" class="w-full h-full object-cover rounded-t-2xl">` :
        `<div class="p-8 text-white text-center bg-gray-400 w-full h-full flex items-center justify-center">No Image</div>`;

    document.getElementById('modalLocation').textContent = listing.location;
    document.getElementById('modalTitle').textContent = listing.title;
    document.getElementById('modalHost').textContent = `Posted by ${listing.hostName || 'Unknown'}`;
    document.getElementById('modalPrice').textContent = `${listing.price} DH`;
    document.getElementById('modalDescription').textContent = listing.description;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal(event) {
    if (!event || event.target.id === 'listingModal') {
        const modal = document.getElementById('listingModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
});