    <div class="sticky top-0 bg-gray-900 text-gray-100 flex justify-between items-center p-4 w-full z-50">
        <a href="home" class="text-3xl block font-bold text-cyan-400">Kari</a>
        <button onclick="toggleSidebar()" class="focus:outline-none focus:bg-gray-700 p-2 rounded">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <nav id="sidebar" class="fixed bg-gray-900 text-gray-100 w-64 space-y-2 py-7 px-2 top-0 right-0 h-screen transform translate-x-full transition duration-200 ease-in-out z-50 flex flex-col">
        <?php
        if (isset($_SESSION['user_object'])) {
            $role = $_SESSION['user_object']->getRole() ?? '';
        }else{
            $role = '';
        }
        ?>

        <a href="home" class="text-3xl font-bold mb-8 px-4 text-cyan-400">Kari</a>

        <div class="flex-grow space-y-2">
            <a href="profile" class="flex items-center p-2 bg-cyan-400 rounded-2xl text-white font-semibold transition duration-150 ease-in-out shadow-lg">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profile
            </a>

            <a href="allListings" class="flex items-center p-2 bg-cyan-400 rounded-2xl text-white font-semibold transition duration-150 ease-in-out shadow-lg">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 9.5l9-7 9 7M5 10.5V20a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1v-9.5" />
                </svg>

                Listings
            </a>

            <?php if ($role === 'host'): ?>
                <a href="myListings" class="flex items-center p-2 bg-cyan-400 rounded-2xl text-white font-semibold transition duration-150 ease-in-out shadow-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l-9 9m-9-9l9 9" />
                    </svg>
                    My Listings
                </a>
            <?php endif; ?>

            <?php if ($role === 'admin'): ?>
                <a href="allListings" class="flex items-center p-2 bg-cyan-400 rounded-2xl text-white font-semibold transition duration-150 ease-in-out shadow-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l-9 9m-9-9l9 9" />
                    </svg>
                    All Listings
                </a>
            <?php endif; ?>
            <?php if ($role === 'host'): ?>
                <a href="addListing" class="flex items-center p-2 bg-cyan-400 rounded-2xl text-white font-semibold transition duration-150 ease-in-out shadow-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Listing
                </a>
            <?php endif; ?>
        </div>
        <div class="mt-auto pt-4 border-t border-gray-800">
            <a href="logout-action" class="flex items-center p-2 rounded hover:bg-red-900/50 text-red-300 hover:text-red-100 transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </a>
        </div>

    </nav>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('translate-x-full');
            overlay.classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.querySelector('button[onclick="toggleSidebar()"]');
            const isOpen = !sidebar.classList.contains('translate-x-full');

            if (isOpen && !sidebar.contains(e.target) && !menuBtn.contains(e.target)) {
                toggleSidebar();
            }
        });
    </script>