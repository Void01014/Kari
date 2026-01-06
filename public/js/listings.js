// --- GLOBAL VARIABLES ---
    let currentListingPrice = 0;

    // --- UI TOGGLE FUNCTIONS ---
    function showMainContent() {
        // We fetch these INSIDE the function to ensure they aren't null
        const mainContent = document.getElementById('modalMainContent');
        const bookingForm = document.getElementById('bookingForm');

        if (mainContent && bookingForm) {
            mainContent.classList.remove('hidden');
            bookingForm.classList.add('hidden');
        } else {
            console.error("Critical Error: Modal elements not found in DOM.");
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

            const today = new Date().toISOString().split('T')[0];
            const checkIn = document.getElementById('checkIn');
            const checkOut = document.getElementById('checkOut');
            if (checkIn) checkIn.min = today;
            if (checkOut) checkOut.min = today;
        }
    }

    // --- MODAL CORE LOGIC ---
    function openModal(listing) {
        const modal = document.getElementById('listingModal');
        if (!modal) {
            console.error("Listing Modal ID not found");
            return;
        }

        // Reset view to details
        showMainContent();

        // Populate Modal Fields
        const imageDiv = document.getElementById('modalImage');
        if (imageDiv) {
            imageDiv.innerHTML = listing.image ?
                `<img src="public/uploads/${listing.image}" alt="${listing.title}" class="w-full h-full object-cover rounded-t-2xl">` :
                `<div class="p-8 text-white text-center">No Image</div>`;
        }

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
                        class="flex-1 bg-cyan-400 text-white px-8 py-4 rounded-lg font-bold text-lg hover:shadow-[0_0_20px_rgba(34,211,238,0.5)] hover:scale-105 transition duration-200">
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
        // If event is null (called via Esc or button) or target is the modal backdrop
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

    // --- INITIALIZE LISTENERS ---
    document.addEventListener('DOMContentLoaded', function() {
        const checkIn = document.getElementById('checkIn');
        const checkOut = document.getElementById('checkOut');

        function calculateTotal() {
            const nightsEl = document.getElementById('numberOfNights');
            const totalEl = document.getElementById('totalPrice');

            if (checkIn.value && checkOut.value) {
                const start = new Date(checkIn.value);
                const end = new Date(checkOut.value);
                const nights = Math.ceil((end - start) / (1000 * 60 * 60 * 24));

                if (nights > 0) {
                    nightsEl.textContent = nights;
                    totalEl.textContent = (nights * currentListingPrice).toFixed(2) + ' DH';
                } else {
                    nightsEl.textContent = '0';
                    totalEl.textContent = '0 DH';
                }
            }
        }

        if (checkIn && checkOut) {
            checkIn.addEventListener('change', function() {
                checkOut.min = this.value;
                calculateTotal();
            });
            checkOut.addEventListener('change', calculateTotal);
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });