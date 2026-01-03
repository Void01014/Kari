<?php
    $user = $_SESSION['user_object'] ?? null;
    $pfp = strtoupper(substr($user->getName(), 0,1));
?>
    <main class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="profile-card p-8 mb-6">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="relative">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-indigo-400 to-cyan-400 flex items-center justify-center text-white text-4xl font-bold">
                        <?=  $pfp?>
                    </div>
                </div>
                <div class="flex-grow text-center md:text-left">
                    <h1 class="text-3xl font-bold text-gray-800"><?=  $user->getName() ?></h1>
                    <p class="text-gray-600"><?= $user->getEmail() ?></p>
                </div>
            </div>
        </div>

        <div class="profile-card p-8 mb-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Personal Information</h2>
                <button onclick="toggleEdit('personal')" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                    Edit
                </button>
            </div>
            <form id="personalForm" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 md:flex md:flex-col items-center md:gap-5">
                    <div>
                        <label class="block text-gray-700 mb-2 font-semibold">User Name</label>
                        <input type="text" value="<?= $user->getName() ?>" class="w-70 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" disabled>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2 font-semibold">Email</label>
                        <input type="email" value="<?= $user->getEmail() ?>" class="w-70 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" disabled>
                    </div>
                </div>
                <div class="hidden" id="personalActions">
                    <div class="flex gap-3 mt-4">
                        <button type="button" onclick="saveChanges('personal')" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Save Changes
                        </button>
                        <button type="button" onclick="toggleEdit('personal')" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="profile-card p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Security</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-semibold text-gray-800">Password</h3>
                        <p class="text-sm text-gray-600">Last changed 2 months ago</p>
                    </div>
                    <button onclick="changePassword()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Change
                    </button>
                </div>
            </div>
        </div>

    </main>
    
    <script>
        function toggleEdit(section) {
            const form = document.getElementById(section + 'Form');
            const inputs = form.querySelectorAll('input');
            const actions = document.getElementById(section + 'Actions');

            inputs.forEach(input => {
                input.disabled = !input.disabled;
            });

            actions.classList.toggle('hidden');
        }

        function saveChanges(section) {
            Swal.fire({
                title: 'Success!',
                text: 'Your changes have been saved',
                icon: 'success',
                confirmButtonColor: '#4f46e5'
            });
            toggleEdit(section);
        }

        function changePassword() {
            Swal.fire({
                title: 'Change Password',
                html: `
                    <input type="password" id="currentPassword" class="swal2-input" placeholder="Current Password">
                    <input type="password" id="newPassword" class="swal2-input" placeholder="New Password">
                    <input type="password" id="confirmPassword" class="swal2-input" placeholder="Confirm Password">
                `,
                confirmButtonText: 'Change Password',
                confirmButtonColor: '#4f46e5',
                showCancelButton: true,
                preConfirm: () => {
                    return {
                        current: document.getElementById('currentPassword').value,
                        new: document.getElementById('newPassword').value,
                        confirm: document.getElementById('confirmPassword').value
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Success!', 'Password changed successfully', 'success');
                }
            });
        }
    </script>