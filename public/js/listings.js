// --- GLOBAL VARIABLES ---
let currentListingPrice = 0;
let checkIn_pickr, checkOut_pickr;

let disabled_dates_objects = [];
if (typeof disabled_dates !== 'undefined') {
    for (let i = 0; i < disabled_dates.length; i++) {
        disabled_dates_objects.push({
            id: disabled_dates[i].id,
            dates: [disabled_dates[i].from, disabled_dates[i].to]
        });
    }
}

// --- UI TOGGLE FUNCTIONS (Global Scope) ---

function showMainContent() {
    const mainContent = document.getElementById('modalMainContent');
    const bookingForm = document.getElementById('bookingForm');
    if (mainContent && bookingForm) {
        mainContent.classList.remove('hidden');
        bookingForm.classList.add('hidden');
    }
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

        // Reset inputs and total when switching to form
        document.getElementById('checkIn').value = '';
        document.getElementById('checkOut').value = '';
        document.getElementById('numberOfNights').textContent = '0';
        document.getElementById('totalPrice').textContent = '0 DH';
    }
}

// --- CORE MODAL LOGIC ---

function updateDisabledDates(currentId) {
    let disabled_dates_temp = [];
    
    console.log("Filtering for Listing ID:", currentId); // Debug line

    disabled_dates_objects.forEach(item => {
        console.log(item.id);
        console.log(currentId);
        // Use String() to ensure "3" matches 3
        if (String(item.id) === String(currentId)) {
            disabled_dates_temp.push({
                from: item.dates[0],
                to: item.dates[1]
            });
        }
    });

    console.log("Dates found:", disabled_dates_temp); // Debug line

    if (checkIn_pickr && checkOut_pickr) {
        checkIn_pickr.set("disable", disabled_dates_temp);
        checkOut_pickr.set("disable", disabled_dates_temp);
    }
}

function openModal(listing) {
    const modal = document.getElementById('listingModal');
    if (!modal) return;

    showMainContent();
    updateDisabledDates(listing.id);

    // Populate Fields
    document.getElementById('modalImage').innerHTML = listing.image ?
        `<img src="public/uploads/${listing.image}" alt="${listing.title}" class="w-full h-full object-cover rounded-t-2xl">` :
        `<div class="p-8 text-white text-center">No Image</div>`;

    document.getElementById('modalLocation').textContent = listing.location;
    document.getElementById('modalTitle').textContent = listing.title;
    document.getElementById('modalHost').textContent = `Posted by ${listing.hostName}`;
    document.getElementById('modalPrice').textContent = `${listing.price} DH`;
    document.getElementById('modalDescription').textContent = listing.description;

    const actionsDiv = document.getElementById('modalActions');
    actionsDiv.innerHTML = '';

    if (userRole === 'traveler') {
        actionsDiv.innerHTML = `
            <button onclick="bookListing(${listing.id}, ${listing.price})" 
                    class="flex-1 bg-cyan-400 text-white px-8 py-4 rounded-lg font-bold text-lg hover:scale-105 transition">
                Book Now
            </button>`;
    } else if (userRole === 'host' && listing.hostId == userId) {
        actionsDiv.innerHTML = `
            <a href="editListing-action?id=${listing.id}" class="flex-1 bg-indigo-500 text-white px-8 py-4 rounded-lg font-bold text-lg text-center">Edit</a>
            <button onclick="deleteListing(${listing.id})" class="ml-2 bg-red-500 text-white px-8 py-4 rounded-lg font-bold text-lg">Delete</button>`;
    }

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

function bookListing(id, price) {
    showBookingForm(id, price);
}

function calculateTotal() {
    const nightsEl = document.getElementById('numberOfNights');
    const totalEl = document.getElementById('totalPrice');
    const inVal = document.getElementById('checkIn').value;
    const outVal = document.getElementById('checkOut').value;

    if (inVal && outVal) {
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

// --- INITIALIZATION ---

document.addEventListener('DOMContentLoaded', function () {
    // 1. Initialize Flatpickr
    checkIn_pickr = flatpickr("#checkIn", {
        minDate: "today",
        dateFormat: "Y-m-d"
    });

    checkOut_pickr = flatpickr("#checkOut", {
        minDate: "today",
        dateFormat: "Y-m-d"
    });

    // 2. Add Event Listeners
    const checkInInput = document.getElementById('checkIn');
    const checkOutInput = document.getElementById('checkOut');

    if (checkInInput && checkOutInput) {
        checkInInput.addEventListener('change', function () {
            checkOut_pickr.set("minDate", this.value);
            calculateTotal();
        });
        checkOutInput.addEventListener('change', calculateTotal);
    }

    // Escape key to close
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });
});