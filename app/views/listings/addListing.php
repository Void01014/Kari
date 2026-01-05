<main class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="form-card p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Add New Listing</h1>

        <form id="listingForm" method="POST" action="addListing-action" enctype="multipart/form-data">

            <div class="mb-6">
                <label class="block text-gray-700 mb-2 font-semibold">Title</label>
                <input
                    type="text"
                    name="title"
                    placeholder="e.g. Cozy apartment near beach"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 mb-2 font-semibold">Description</label>
                <textarea
                    name="description"
                    rows="4"
                    placeholder="Describe your place..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2 font-semibold">Price (per night)</label>
                <input
                type="number"
                name="price"
                placeholder="50"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 mb-2 font-semibold">Location</label>
                <input
                    type="text"
                    name="location"
                    placeholder="e.g. Rabat Agdal"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2 font-semibold">Upload Image</label>
                <div class="upload-area rounded-lg p-6 text-center cursor-pointer">
                    <input
                        type="file"
                        name="image"
                        id="imageInput"
                        accept="image/*"
                        class="hidden"
                        onchange="previewImage(event)">
                    <label for="imageInput" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-600">Click to upload</p>
                    </label>
                </div>
                <div id="imagePreview" class="mt-4"></div>
            </div>

            <div class="flex gap-4">
                <button
                    type="submit"
                    class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                    Create Listing
                </button>
                <a
                    href="addListing-action"
                    class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-semibold text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</main>

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

    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-48 object-cover rounded-lg">
                    `;
            };
            reader.readAsDataURL(file);
        }
    }
</script>