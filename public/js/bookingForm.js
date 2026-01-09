let disabled_dates_objects = [];
if (typeof disabled_dates !== 'undefined' && Array.isArray(disabled_dates)) {
    disabled_dates_objects = disabled_dates.map(item => ({
        id: item.id,
        dates: [item.from, item.to]
    }));
}

function showBookingForm(listingId, price) {
    const mainContent = document.getElementById('modalMainContent');
    const bookingForm = document.getElementById('bookingForm');

    if (mainContent && bookingForm) {
        mainContent.classList.add('hidden');
        bookingForm.classList.remove('hidden');

        document.getElementById('bookingListingId').value = listingId;
        document.getElementById('bookingPrice').textContent = price + ' DH';
        currentListingPrice = parseFloat(price);

        document.getElementById('checkIn').value = '';
        document.getElementById('checkOut').value = '';
        document.getElementById('numberOfNights').textContent = '0';
        document.getElementById('totalPrice').textContent = '0 DH';
    }
}

function bookListing(id, price) {
    showBookingForm(id, price);
}

function calculateTotal() {
    const nightsEl = document.getElementById('numberOfNights');
    const totalEl = document.getElementById('totalPrice');
    const inVal = document.getElementById('checkIn').value;
    const outVal = document.getElementById('checkOut').value;

    if (inVal && outVal && nightsEl && totalEl) {
        const start = new Date(inVal);
        const end = new Date(outVal);
        const diff = end - start;
        const nights = Math.ceil(diff / (1000 * 60 * 60 * 24));

        if (nights > 0) {
            nightsEl.textContent = nights;
            totalEl.textContent = (nights * currentListingPrice).toFixed(2) + ' DH';
        } else {
            nightsEl.textContent = '0';
            totalEl.textContent = '0 DH';
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const checkInEl = document.getElementById('checkIn');
    if (checkInEl) {
        checkIn_pickr = flatpickr("#checkIn", { minDate: "today", dateFormat: "Y-m-d" });
        checkOut_pickr = flatpickr("#checkOut", { minDate: "today", dateFormat: "Y-m-d" });

        checkInEl.addEventListener('change', function () {
            checkOut_pickr.set("minDate", this.value);
            calculateTotal();
        });
        document.getElementById('checkOut').addEventListener('change', calculateTotal);
    }
});

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

    const actionsDiv = document.getElementById('modalActions');
    if (actionsDiv) {
        actionsDiv.innerHTML = '';
        if (typeof userRole !== 'undefined' && userRole === 'traveler' && document.getElementById('bookingForm')) {
            actionsDiv.innerHTML = `
                <button onclick="bookListing(${listing.id}, ${listing.price})" 
                        class="flex-1 bg-cyan-400 text-white px-8 py-4 rounded-lg font-bold text-lg hover:scale-105 transition">
                    Book Now
                </button>`;
        } else if (typeof userRole !== 'undefined' && userRole === 'host' && listing.hostId == userId) {
            actionsDiv.innerHTML = `
                <a href="editListing-action?id=${listing.id}" class="flex-1 bg-indigo-500 text-white px-8 py-4 rounded-lg font-bold text-lg text-center leading-[3rem]">Edit</a>
                <button onclick="deleteListing(${listing.id})" class="ml-2 bg-red-500 text-white px-8 py-4 rounded-lg font-bold text-lg">Delete</button>`;
        }
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}