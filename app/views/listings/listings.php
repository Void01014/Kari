<main class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-white">Browse Listings</h1>
        <a href="addListing-action" class="bg-white text-cyan-400 px-6 py-3 rounded-lg font-semibold hover:shadow-[0_0_15px_white] hover:scale-105 transition duration-200">
            + Add Listing
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <?php if (!empty($slistings)): ?>
            <?php foreach ($listings as $listing): ?>
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-[0_0_20px_rgba(255,255,255,0.5)] hover:scale-105 transition duration-300 cursor-pointer" 
                     onclick="viewListing(<?php echo $listing->getId(); ?>)">
                    
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
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($listing->getTitle()); ?></h3>
                        <p class="text-gray-600 mb-4 line-clamp-2"><?php echo htmlspecialchars($listing->getDescription()); ?></p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-cyan-400"><?php echo htmlspecialchars($listing->getPrice()); ?> DH</span>
                            <span class="text-sm text-gray-500">per night</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full flex flex-col items-center justify-center py-20">
                <h2 class="text-2xl text-white font-bold mb-2">No listings yet</h2>
                <p class="text-white mb-6">Be the first to add a listing!</p>
                <a href="addListing-action" class="bg-white text-cyan-400 px-6 py-3 rounded-lg font-semibold">
                    Create First Listing
                </a>
            </div>
        <?php endif; ?>

    </div>
</main>