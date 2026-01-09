<?php
if (isset($_SESSION['user_object'])) {
    $role = $_SESSION['user_object']->getRole();
    $userId = $_SESSION['user_object']->getId();
}
?>

<h1 class="text-4xl font-bold text-white mt-10">Browse Listings</h1>
<main class="container mx-auto px-4 py-8"> <div class="flex justify-between items-center mt-10 mb-8">
        <h1 class="text-4xl font-bold text-white">
            <?php echo ($role === 'host') ? 'My Listings' : 'My Bookings'; ?>
        </h1>
        
        <?php if ($role === "host"): ?>
            <a href="addListing-action" class="bg-white text-cyan-400 px-6 py-3 rounded-lg font-semibold hover:shadow-[0_0_15px_white] hover:scale-105 transition duration-200">
                + Add Listing
            </a>
        <?php endif; ?>
    </div>

    <div id="listingsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($bookings)): ?>
            <?php foreach ($bookings as $booking): 
                $listing = $booking->getListing(); 
                if (!$listing) continue; // Safety check
            ?>
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-[0_0_20px_rgba(255,255,255,0.5)] hover:scale-105 transition duration-300 cursor-pointer relative"
                    onclick='openModal(<?php echo htmlspecialchars(json_encode([
                        "id" => $listing->getID(),
                        "title" => $listing->getTitle(),
                        "description" => $listing->getDescription(),
                        "price" => $booking->getTotalPrice(),
                        "image" => $listing->getImage(),
                        "location" => $listing->getLocation(),
                        "hostId" => $listing->getHostID(),
                        "hostName" => $listing->getHostName()
                    ]), ENT_QUOTES, "UTF-8"); ?>)'>

                    <div class="absolute top-4 left-4 z-20 bg-cyan-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                        Booked
                    </div>
                    <div class="h-48 bg-gradient-to-br from-indigo-400 to-cyan-400 flex items-center justify-center">
                        <?php if ($listing->getImage()): ?>
                            <img src="public/uploads/<?php echo htmlspecialchars($listing->getImage()); ?>"
                                alt="<?php echo htmlspecialchars($listing->getTitle()); ?>"
                                class="w-full h-full object-cover">
                        <?php else: ?>
                            <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l-9 9m-9-9l9 9" />
                            </svg>
                        <?php endif; ?>
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($listing->getTitle()); ?></span>
                            <span class="text-sm text-blue-900 font-semibold bg-blue-50 px-2 py-1 rounded"><?php echo htmlspecialchars($listing->getLocation()); ?></span>
                        </div>

                        <div class="flex items-center text-gray-500 text-sm mb-4">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span><?php echo $booking->getStartDate(); ?> — <?php echo $booking->getEndDate(); ?></span>
                        </div>

                        <div class="flex justify-between items-center border-t pt-4">
                            <span class="text-xs text-gray-400 uppercase tracking-wider">Booking Status</span>
                            <span class="text-lg font-bold text-green-500">Confirmed</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-20">
                <h2 class="text-2xl text-white opacity-50 font-semibold">You haven't booked any trips yet!</h2>
                <a href="listings" class="mt-4 inline-block text-cyan-400 hover:underline">Browse Moroccan homes</a>
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
                        <p class="text-gray-500">Total Price</p>
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
        </div>
    </div>
</div>

<script>
    const userRole = "<?php echo $role ?? ''; ?>";
    const userId = <?php echo $userId ?? 'null'; ?>;
</script>