
    <main class="md:w-[30%] h-screen">
        <form action="register-action" method="post" class="flex flex-col items-center gap-2 md:gap-5 h-full bg-cyan-400 shadow-[0_0_20px_gray] p-15" id="form">
            <h1 class="text-4xl text-center text-white">Sign Up</h1>
            <div class="w-[70%]">
                <label for="role">Role</label>
                <select name="role" id="role" class="bg-white w-full rounded-lg p-2">
                    <option value="default" disabled selected>choose a Role</option>
                    <option value="traveler">Traveler</option>
                    <option value="host">Host</option>
                </select>
            </div>
            <div class="w-full">
                <label for="username">Username</label>
                <input class="bg-white rounded-lg p-2 w-full" placeholder="username" type="text" name="username" id="username">
            </div>
            <div class="w-full">
                <label for="email">Email</label>
                <input class="bg-white rounded-lg p-2 w-full" placeholder="email" type="text" name="email" id="email">
            </div>
            <div class="w-full">
                <label for="password">password</label>
                <input class="bg-white rounded-lg p-2 w-full" placeholder="password" type="password" name="password" id="password">
            </div>
            <button class="w-50 bg-white p-2 rounded-lg mt-10 hover:shadow-[0_0_10px_gray] hover:bg-blue-500 hover:scale-110 hover:text-white transition duration-200 cursor-pointer" type="submit" name="signUp">Sign Up</button>
            <a class="underline" href="login">Sign in</a>
        </form>
    </main>
