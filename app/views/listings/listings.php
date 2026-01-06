<?php
if (isset($_SESSION['user_object'])) {
    $role = $_SESSION['user_object']->getRole();
    $userId = $_SESSION['user_object']->getId();
}
?>

<main class="container mx-auto px-4 py-8">
    <?php if ($role === "host"): ?>
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-white">Browse Listings</h1>
            <a href="addListing-action" class="bg-white text-cyan-400 px-6 py-3 rounded-lg font-semibold hover:shadow-[0_0_15px_white] hover:scale-105 transition duration-200">
                + Add Listing
            </a>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <?php if (!empty($listings)): ?>
            <?php foreach ($listings as $listing): ?>
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-[0_0_20px_rgba(255,255,255,0.5)] hover:scale-105 transition duration-300 cursor-pointer"
                    onclick='openModal(<?php echo json_encode([
                                            "id" => $listing->getId(),
                                            "title" => $listing->getTitle(),
                                            "description" => $listing->getDescription(),
                                            "price" => $listing->getPrice(),
                                            "image" => $listing->getImage(),
                                            "location" => $listing->getLocation(),
                                            "hostId" => $listing->getHostID(),
                                            "hostName" => $listing->getHostName()
                                        ]); ?>)'>

                    <div class="h-48 bg-gradient-to-br from-indigo-400 to-cyan-400 flex items-center justify-center">
                        <?php if (!empty($listing->getImage())): ?>
                            <img src="public/uploads/<?php echo htmlspecialchars($listing->getImage()); ?>"
                                alt="<?php echo htmlspecialchars($listing->getTitle()); ?>"
                                class="w-full h-full object-cover">
                        <?php else: ?>
                            <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l-9 9m-9-9l9 9" />
                            </svg>
                        <?php endif; ?>
                    </div>

                    <div class="flex flex-wrap p-6">
                        <span class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($listing->getTitle()); ?></span>
                        <span class="text-xl text-blue-900 ml-auto"><?php echo htmlspecialchars($listing->getLocation()); ?></span>
                    </div>
                    <div class="flex justify-between items-center m-6 mt-0">
                        <span class="text-2xl font-bold text-cyan-400"><?php echo htmlspecialchars($listing->getPrice()); ?> DH</span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full flex flex-col items-center justify-center py-20">
                <h2 class="text-2xl text-white font-bold mb-2">No listings yet</h2>
                <?php if ($role === "host"): ?>
                    <p class="text-white mb-6">Be the first to add a listing!</p>
                    <a href="addListing-action" class="bg-white text-cyan-400 px-6 py-3 rounded-lg font-semibold">
                        Create First Listing
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</main>
<?php ?>
<div id="listingModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50" onclick="closeModal(event)">
    <div class="bg-white rounded-2xl max-w-3xl w-full mx-4 max-h-[90vh] overflow-y-auto relative" onclick="event.stopPropagation()">

        <button onclick="closeModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-70 transition z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div id="modalMainContent">
            <div id="modalImage" class="h-80 bg-gradient-to-br from-indigo-400 to-cyan-400 flex items-center justify-center rounded-t-2xl"></div>

            <div class="p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 id="modalLocation" class="text-xl text-blue-900 mb-1"></h2>
                        <h2 id="modalTitle" class="text-3xl font-bold text-gray-800 mb-2"></h2>
                        <p id="modalHost" class="text-gray-600"></p>
                    </div>
                    <div class="text-right">
                        <span id="modalPrice" class="text-4xl font-bold text-cyan-400"></span>
                        <p class="text-gray-500">per night</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Description</h3>
                    <p id="modalDescription" class="text-gray-700 leading-relaxed"></p>
                </div>

                <div id="modalActions" class="flex gap-4"></div>
            </div>
        </div>

        <div id="bookingForm" class="hidden p-8">
            <button onclick="showMainContent()" class="flex items-center text-gray-600 mb-6 hover:text-gray-800 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Details
            </button>

            <h2 class="text-3xl font-bold text-gray-800 mb-6">Book Your Stay</h2>

            <form id="bookingFormElement" method="POST" action="booking-action" class="space-y-6">
                <input type="hidden" name="listing_id" id="bookingListingId">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-2 font-semibold">Check-in</label>
                        <input type="date" name="check_in" id="checkIn" class="w-full px-4 py-3 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2 font-semibold">Check-out</label>
                        <input type="date" name="check_out" id="checkOut" class="w-full px-4 py-3 border rounded-lg" required>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between mb-2">
                        <span>Nights:</span> <span id="numberOfNights" class="font-bold">0</span>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-semibold">Number of Guests</label>
                        <div class="relative">
                            <select
                                name="guests"
                                id="numGuests"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-400 appearance-none bg-white"
                                required>
                                <option value="1">1 Guest</option>
                                <option value="2">2 Guests</option>
                                <option value="3">3 Guests</option>
                                <option value="4">4 Guests</option>
                                <option value="5">5+ Guests</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between text-xl font-bold border-t pt-2">
                        <span>Total:</span> <span id="totalPrice" class="text-cyan-400">0 DH</span>
                    </div>
                    <p id="bookingPrice" class="hidden"></p>
                </div>

                <button type="submit" class="w-full bg-cyan-400 text-white py-4 rounded-lg font-bold text-xl hover:bg-cyan-500 transition">
                    Confirm Booking
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const userRole = "<?php echo $role ?? ''; ?>";
    const userId = <?php echo $userId ?? 'null'; ?>;
</script>