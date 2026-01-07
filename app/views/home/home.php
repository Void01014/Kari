<main class="h-screen flex items-center justify-center px-4">
    
    <div class="text-center max-w-4xl">
        
        <!-- Logo/Icon -->
        <div class="mb-8 animate-bounce">
            <svg class="w-24 h-24 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9.5l9-7 9 7M5 10.5V20a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1v-9.5" />
            </svg>
        </div>

        <!-- Main Heading -->
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">
            Kari
        </h1>

        <!-- Subheading -->
        <p class="text-xl md:text-2xl text-white mb-12 opacity-90">
            Find your perfect stay, anywhere in the world
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <?php if (isset($_SESSION['user_object'])): ?>
                <a href="allListings" class="bg-white text-cyan-400 px-8 py-4 rounded-lg font-bold text-lg hover:shadow-[0_0_20px_white] hover:scale-105 transition duration-200">
                    Browse Listings
                </a>
                <?php if ($_SESSION['user_object']->getRole() === 'host'): ?>
                    <a id="addListingBtn" href="addListing-action" class="border-2 border-white text-white px-8 py-4 rounded-lg font-bold text-lg hover:text-cyan-400 hover:scale-105 transition duration-200">
                        Add Your Listing
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <a href="login" class="bg-white text-cyan-400 px-8 py-4 rounded-lg font-bold text-lg hover:shadow-[0_0_20px_white] hover:scale-105 transition duration-200">
                    Sign In
                </a>
                <a href="signUp" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white hover:text-cyan-400 hover:scale-105 transition duration-200">
                    Sign Up
                </a>
            <?php endif; ?>
        </div>

        <!-- Features -->
        <div class="flex flex-col md:flex-row items-center md:items-stretch gap-8 mt-10" id="footer">
            <div class="text-white">
                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="text-xl font-bold mb-2">Easy Search</h3>
                <p class="opacity-80">Find the perfect place in seconds</p>
            </div>
            
            <div class="text-white">
                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <h3 class="text-xl font-bold mb-2">Secure Booking</h3>
                <p class="opacity-80">Your transactions are safe with us</p>
            </div>
            
            <div class="text-white">
                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
                <h3 class="text-xl font-bold mb-2">Best Prices</h3>
                <p class="opacity-80">Great deals on amazing places</p>
            </div>
        </div>

    </div>

</main>

<style>
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    .animate-bounce {
        animation: bounce 2s ease-in-out infinite;
    }

    #footer > *{
        padding: 10px;
        border-radius: 20px;
        background-color: rgba(36, 52, 66, 0.285);
        width: calc(18rem);
    }
</style>