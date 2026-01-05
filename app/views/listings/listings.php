<?php
    if (isset($_SESSION['user_object'])){
        $role = $_SESSION['user_object']->getRole();
        $userId = $_SESSION['user_object']->getId();
    }
?>

<main class="container mx-auto px-4 py-8">
    <?php if($role === "host"):?>
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-white">Browse Listings</h1>
            <a href="addListing-action" class="bg-white text-cyan-400 px-6 py-3 rounded-lg font-semibold hover:shadow-[0_0_15px_white] hover:scale-105 transition duration-200">
                + Add Listing
            </a>
        </div>
    <?php endif;?>

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
                <?php if($role === "host"):?>
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
<!-- Modal -->
<div id="listingModal" class="fixed inset-0 bg-gray-500 bg-opacity-[100%] hidden items-center justify-center z-50" onclick="closeModal(event)">
    <div class="bg-white rounded-2xl max-w-3xl w-full mx-4 max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        
        <!-- Close Button -->
        <button onclick="closeModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-70 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Image -->
        <div id="modalImage" class="h-80 bg-gradient-to-br from-indigo-400 to-cyan-400 flex items-center justify-center">
        </div>

        <!-- Content -->
        <div class="p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 id="modalLocation" class="text-3xl text-blue-900 mb-2"></h2>
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

            <!-- Action Buttons -->
            <div id="modalActions" class="flex gap-4"></div>
        </div>
    </div>
</div>

<script>
    const userRole = "<?php echo $role ?? ''; ?>";
    const userId = <?php echo $userId ?? 'null'; ?>;

    function openModal(listing) {
        const modal = document.getElementById('listingModal');
        
        // Set image
        const imageDiv = document.getElementById('modalImage');
        if (listing.image) {
            imageDiv.innerHTML = `<img src="public/uploads/${listing.image}" alt="${listing.title}" class="w-full h-full object-cover">`;
        } else {
            imageDiv.innerHTML = `<svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l-9 9m-9-9l9 9" />
            </svg>`;
        }

        // Set content
        document.getElementById('modalLocation').textContent = listing.location;
        document.getElementById('modalTitle').textContent = listing.title;
        document.getElementById('modalHost').textContent = `Posted by ${listing.hostName}`;
        document.getElementById('modalPrice').textContent = `${listing.price} DH`;
        document.getElementById('modalDescription').textContent = listing.description;

        // Set action buttons based on role
        const actionsDiv = document.getElementById('modalActions');
        actionsDiv.innerHTML = '';

        if (userRole === 'traveler') {
            actionsDiv.innerHTML = `
                <button onclick="bookListing(${listing.id})" 
                        class="flex-1 bg-cyan-400 text-white px-8 py-4 rounded-lg font-bold text-lg hover:shadow-[0_0_20px_rgba(34,211,238,0.5)] hover:scale-105 transition duration-200">
                    Book Now
                </button>
            `;
        }
        // else if (userRole === 'host' && listing.hostId == userId) {
        //     actionsDiv.innerHTML = `
        //         <a href="editListing-action?id=${listing.id}" 
        //            class="flex-1 bg-indigo-500 text-white px-8 py-4 rounded-lg font-bold text-lg text-center hover:shadow-[0_0_20px_rgba(99,102,241,0.5)] hover:scale-105 transition duration-200">
        //             Edit Listing
        //         </a>
        //         <button onclick="deleteListing(${listing.id})" 
        //                 class="bg-red-500 text-white px-8 py-4 rounded-lg font-bold text-lg hover:shadow-[0_0_20px_rgba(239,68,68,0.5)] hover:scale-105 transition duration-200">
        //             Delete
        //         </button>
        //     `;
        // }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal(event) {
        if (!event || event.target.id === 'listingModal') {
            const modal = document.getElementById('listingModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    function bookListing(id) {
        window.location.href = 'booking-action?listing_id=' + id;
    }

    function deleteListing(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to undo this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'deleteListing-action?id=' + id;
            }
        });
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>