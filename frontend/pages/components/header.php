<header class="fixed top-0 left-0 w-full z-50 shadow-2xl rounded-b-2xl backdrop-blur-md bg-white/30 
    hover:bg-gray-700 hover:text-gray-200 transition-colors duration-300 animate-slide-down">
    <nav class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            <!-- Left Search bar -->
            <form class="relative w-72" method="GET" action="">
                <input
                type="text"
                placeholder="Search product here..."
                class="w-full pl-4 pr-10 py-2 rounded-full shadow-xl backdrop-blur-2xl hover:text-gray-200 placeholder-gray-400 transition-colors duration-300 focus:outline-none focus:ring-2 hover:bg-gray-800"
                name="prodName"
                id="prodName"
                >

                <!-- Icon inside input -->
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 border-l border-gray-900 h-full">
                    <button type="submit" class="p-1">
                        <img class="icon" src="/frontend/assets/icons/search.svg" alt="Search">
                    </button>
                </div>
            </form>

            <!-- Center Navigation links -->
            <div class="flex space-x-8 justify-center flex-1">
                <a href="/" class="links">Home</a>
                <a href="/catalog" class="links">Catalog</a>
                <a href="#" class="links">About Us</a>
            </div>

            <!-- Right User & Cart -->
            <div class="flex items-center space-x-4">
                <a href="#" class="p-2 rounded-full hover:bg-gray-500 transition-colors duration-300">
                    <img class="icon" src="/frontend/assets/icons/user.svg" alt="User">
                </a>
                <a href="/cart" class="p-2 rounded-full hover:bg-gray-500 transition-colors duration-300">
                    <img class="icon" src="/frontend/assets/icons/cart.svg" alt="Cart">
                </a>
            </div>
        </div>
    </nav>
</header>