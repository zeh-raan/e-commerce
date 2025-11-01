<header class="fixed top-0 left-0 w-full z-50 shadow-2xl rounded-b-2xl backdrop-blur-md bg-white/30 
    hover:bg-gray-700 hover:text-gray-200 transition-colors duration-300 animate-slide-down">
    <nav class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            <!-- Left Search bar -->
            <form class="flex-1 flex items-center" method="GET" action="/catalog">
                <div class="relative w-62">
                    <input
                        type="text"
                        placeholder="Search product here..."
                        class="w-full pl-4 pr-10 py-2 rounded-full shadow-xl backdrop-blur-2xl hover:text-gray-200 placeholder-gray-400 transition-colors duration-300 focus:outline-none focus:ring-2 hover:bg-gray-800"
                        name="prodName"
                        id="prodName"
                    >

                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-200 transition-colors duration-300">
                        <img src="public/assets/icons/search.svg" class="w-5 h-5">
                    </button>
                </div>
            </form>

            <!-- Center Navigation links -->
            <div class="w-fit flex flex-1 space-x-8 justify-center items-end">
                <!-- <h1 class="text-xl font-bold">Shop.</h1> -->

                <a href="/" class="links pb-0.2">Home</a>
                <a href="/catalog" class="links pb-0.2">Catalog</a>
                <a href="#" class="links pb-0.2">About Us</a>
            </div>

            <!-- Right User & Cart -->
            <div class="flex items-center space-x-4">
                <a id="user-button" href="<?php echo isset($_SESSION['user']) ? '#' : '/signup.html'; ?>" 
                    class="p-2 rounded-full hover:bg-gray-500 transition-colors duration-300">

                    <img id="user-icon" class="icon" src="public/assets/icons<?php echo isset($_SESSION['user']) ? 'logout.svg' : 'user.svg'; ?>">
                </a>
                <a href="/cart.php" class="p-2 rounded-full hover:bg-gray-500 transition-colors duration-300">
                    <img class="icon" src="public/assets/icons/cart.svg">
                </a>
            </div>
        </div>
    </nav>
</header>

<!-- Popup and Overlay -->
<div id="overlay"></div>
<div id="popup"></div> 

<script>
    // Logout Popup
    const $ = (selector) => document.querySelector(selector);

    $("#user-button")?.addEventListener("click", (e) => {
        const icon = $("#user-icon");
        if (icon?.src.includes("logout.svg")) {
            e.preventDefault();

            fetch("/backend/api/logout.php")
            .then(res => res.json())
            .then(data => {
                $("#popup").textContent = data.message;
                $("#popup").classList.add("active");
                $("#overlay").classList.add("active");

                setTimeout(() => {
                    $("#popup").classList.remove("active");
                    $("#overlay").classList.remove("active");
                }, 2000);

                if ( data.success ) {
                    setTimeout(() => {
                        window.location.href = "/signup.html"; // redirect to signup page
                    }, 3000)
                }            
            });
        }
    });
</script>