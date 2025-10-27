<?php
session_start(); // For per user customization
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>File-based E-Commerce</title>

    <!-- CSS CLI File -->
    <link href="frontend/css/output.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <header class="fixed top-0 left-0 w-full z-50 shadow-2xl rounded-b-2xl backdrop-blur-md bg-white/30 
        hover:bg-gray-700 hover:text-gray-200 transition-colors duration-300 animate-slide-down">
        <nav class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">

                <!-- Left Search bar -->
                <form class="relative w-72">
                    <input
                    type="text"
                    placeholder="Search product here..."
                    class="w-full pl-4 pr-10 py-2 rounded-full shadow-xl backdrop-blur-2xl hover:text-gray-200 placeholder-gray-400 transition-colors duration-300 focus:outline-none focus:ring-2 hover:bg-gray-800"
                    >

                    <!-- Icon inside input -->
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 border-l border-gray-900 h-full">
                        <button type="submit" class="p-1">
                            <img class="icon" src="frontend/assets/icons/search.svg" alt="Search">
                        </button>
                    </div>
                </form>

                <!-- Center Navigation links -->
                <div class="flex space-x-8 justify-center flex-1">
                    <a href="#" class="nav-link">Home</a>
                    <a href="#" class="nav-link">Catalog</a>
                    <a href="#" class="nav-link">About Us</a>
                </div>

                <!-- Right User & Cart -->
                <div class="flex items-center space-x-4">
                    <a href="#" class="p-2 rounded-full hover:bg-gray-800 transition-colors duration-300">
                        <img class="icon" src="frontend/assets/icons/user.svg" alt="User">
                    </a>
                    <a href="#" class="p-2 rounded-full hover:bg-gray-800 transition-colors duration-300">
                        <img class="icon" src="frontend/assets/icons/cart.svg" alt="Cart">
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="hero" class="relative h-96 flex flex-col items-center justify-center bg-[url('/frontend/assets/images/bghero.avif')] bg-cover bg-center text-center">
        <div class="relative">
            <h2 id="hero-subtitle" class="text-3xl text-white font-bold mt-7 mr-20 opacity-0"></h2>
            <h1 id="hero-title" class="text-8xl font-extrabold text-white opacity-0 absolute left-1/2 -translate-x-1/2 -top-10 tracking-wide mix-blend-overlay"></h1>
        </div>

        <p id="hero-desc" class="max-w-lg text-gray-100 text-base mt-12 opacity-0 transition-opacity duration-700">
            Discover products of the highest quality, tailored for your needs. Start your journey today.
        </p>
    </section>

    <!-- Section Divider -->
    <img class="absolute opacity-40" src="/frontend/assets/icons/divider.svg">
    <h1 id="feat-product" class="text-5xl font-bold mx-16 my-12 opacity-0 transition-opacity duration-700">Featured Products.</h1>

    <!-- Featured Section -->
    <section id="catalog" class="flex overflow-x-hidden">
        <!-- <button id="prev" class="carousel-nav-btn"><img class="w-30 h-30" src="/frontend/assets/icons/prev.svg"></button> -->
        
        <div id="carousel" class="flex overflow-x-hidden snap-x snap-mandatory scroll-smooth space-x-6">
            <div id="products-display-here" class="slider-container overflow-x-hidden px-8"></div>
        </div>

        <!-- <button id="next" class="carousel-nav-btn"><img class="w-30 h-30" src="/frontend/assets/icons/next.svg"></button> -->
    </section>

    <!-- Just for testing
    <form id="deleteForm" action="/api/delete_product.php" method="POST">
        <input class="border-2 border-black" type="text" name="productId" id="productId">
    </form>
    <script>
        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const productId = document.getElementById('productId').value;
            const payload = {
                product_id: productId
            };
            
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/api/delete_product.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    console.log('Success:', response);
                    alert(response.message || response.error);
                }
            };
            
            xhr.send(JSON.stringify(payload));
        });
    </script>
    -->

  <footer class="bg-gray-700 text-gray-200 py-12 mt-6 rounded-t-2xl shadow-2xl">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">

      <!-- Shop Info -->
      <div>
        <h2 class="text-xl font-bold mb-4">Shop.</h2>
        <p class="text-sm text-gray-400">
          Quality products crafted with care. Bringing elegance and style to your home.
        </p>
      </div>

      <!-- Quick Links -->
      <div>
        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
        <ul class="space-y-2 text-gray-400">
          <li><a href="#" class="footer-link">Home</a></li>
          <li><a href="#" class="footer-link">Products</a></li>
          <li><a href="#" class="footer-link">About</a></li>
          <li><a href="#" class="footer-link">Contact</a></li>
        </ul>
      </div>

      <!-- Customer Service -->
      <div>
        <h3 class="text-lg font-semibold mb-4">Customer Service</h3>
        <ul class="space-y-2 text-gray-400">
          <li><a href="#" class="footer-link">FAQ</a></li>
          <li><a href="#" class="footer-link">Checkout</a></li>
        </ul>
      </div>

      <!-- Social Media -->
      <div>
        <h3 class="text-lg font-semibold mb-4">Follow Us</h3>
        <div class="flex space-x-4">
          <a href="#" class="footer-link">
            <img src="/frontend/assets/icons/facebook.svg" class="icon">
          </a>
          <a href="#" class="footer-link">
            <img src="/frontend/assets/icons/instagram.svg" class="icon">
          </a>
          <a href="#" class="footer-link">
            <img src="/frontend/assets/icons/whatsapp.svg" class="icon">
          </a>
        </div>
      </div>

    </div>

    <!-- Footer Bottom -->
    <div class="mt-4 py-4 border-t border-black text-center text-gray-500 text-sm">
      &copy; 2025 Shop. All rights reserved.
    </div>

  </footer>

  <!-- TS to JS converter (IDK whats its called)-->
  <script src="/frontend/dist/main.js"></script>

  <!-- Hero animations -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const subTitleEl = document.getElementById("hero-subtitle");
      const titleEl = document.getElementById("hero-title");
      const descEl = document.getElementById("hero-desc");
      const featProd = document.getElementById("feat-product");

      const subText = "Welcome to Our";
      const mainText = "SHOP.";
      let i = 0, j = 0;

      // Type "Welcome to"
      function typeSub() {
        if (i < subText.length) {
          subTitleEl.textContent = subText.substring(0, i + 1);
          subTitleEl.style.opacity = 1;
          i++;
          setTimeout(typeSub, 100);
        } else {
          setTimeout(typeMain, 400);
        }
      }

      // Type "SHOP." with larger font size and lower opacity behind
      function typeMain() {
        if (j < mainText.length) {
          titleEl.textContent = mainText.substring(0, j + 1);
          titleEl.style.opacity = 0.4;
          j++;
          setTimeout(typeMain, 150);
        } else {
          setTimeout(() => {
            descEl.style.opacity = 1; // Show paragraph
            featProd.style.opacity = 1; // Show heading
          }, 600);
        }
      }

      // Call animation
      typeSub();
    });

    // Carousel Effect
    const carousel = document.getElementById('carousel');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');

    prevBtn.addEventListener('click', () => {
      carousel.scrollBy({
        left: -carousel.offsetWidth,
        behavior: 'smooth'
      });
    });

    nextBtn.addEventListener('click', () => {
        carousel.scrollBy({
            left: carousel.offsetWidth,
            behavior: 'smooth'
        });
    });

  </script>

    <!-- 4 spaces tabs supremacy!! -->
    <script>

        // Helper function
        const getProductDetails = (productXML) => {
            let productId = productXML["id"];
            let productName = productXML.getElementsByTagName("name")[0].childNodes[0].nodeValue;
            let productDesc = productXML.getElementsByTagName("desc")[0].childNodes[0].nodeValue.slice(0, 64) + "..."; // Includes a shortened version
            let productImg = productXML.getElementsByTagName("img")[0].childNodes[0].nodeValue; // Selecting only 1 image for now

            return {
                id: productId,
                name: productName,
                desc: productDesc,
                img: productImg
            }
        };

        // JavaScript (DOM Manipulation) with XML
        const populateCatalog = (xmlDoc) => {
            const featuredSection = document.getElementById("products-display-here");
            let products = xmlDoc.getElementsByTagName("product");

            if (products.length < 5) {
                return;
            }

            const productDetails = [];
            for (let i = 0; i < products.length; i++) {
                productDetails.push(getProductDetails(products[i]));
            }

            // TODO: Make this code better
            const featuredSectionHTML = `
                <div class="row-span-2 product-card group">
                    <img src="/api/get_image.php?imgName=${productDetails[0].img}" 
                        class="product-image group-hover:scale-105">

                    <div class="product-overlay group-hover:translate-x-0">
                        <div class="product-overlay-content">
                            <p class="text-sm mb-3">${productDetails[0].desc}</p>
                            <a href="/product/${productDetails[0].id}" class="add-to-cart-btn">View</a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-rows-2 gap-4">
                    <div class="product-card group">
                        <img src="/api/get_image.php?imgName=${productDetails[1].img}"
                            class="product-image group-hover:scale-105">
                        
                        <div class="product-overlay group-hover:translate-x-0">
                            <div class="product-overlay-content">
                                <p class="text-sm mb-3">${productDetails[1].desc}</p>
                                <a href="/product/${productDetails[1].id}" class="add-to-cart-btn">View</a>
                            </div>
                        </div>
                    </div>

                    <div class="product-card group">
                        <img src="/api/get_image.php?imgName=${productDetails[2].img}"
                            class="product-image group-hover:scale-105">
                        <div class="product-overlay group-hover:translate-x-0">
                            <div class="product-overlay-content">
                                <p class="text-sm mb-3">${productDetails[2].desc}</p>
                                <a href="/product/${productDetails[2].id}" class="add-to-cart-btn">View</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-rows-2 gap-4">
                    <div class="product-card group">
                        <img src="/api/get_image.php?imgName=${productDetails[3].img}"
                            class="product-image group-hover:scale-105">
                        <div class="product-overlay group-hover:translate-x-0">
                            <div class="product-overlay-content">
                                <p class="text-sm mb-3">${productDetails[3].desc}</p>
                                <a href="/product/${productDetails[3].id}" class="add-to-cart-btn">View</a>
                            </div>
                        </div>
                    </div>

                    <div class="product-card group">
                        <img src="/api/get_image.php?imgName=${productDetails[4].img}"
                            class="product-image group-hover:scale-105">
                        <div class="product-overlay group-hover:translate-x-0">
                            <div class="product-overlay-content">
                                <p class="text-sm mb-3">${productDetails[4].desc}</p>
                                <a href="/product/${productDetails[4].id}" class="add-to-cart-btn">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            featuredSection.innerHTML = featuredSectionHTML;
        };

        // AJAX with XML
        const getAllProducts = () => {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () => {
                if ((xhr.readyState == 4) && (xhr.status == 200)) {
                    populateCatalog(xhr.responseXML);
                }
            };

            xhr.open("GET", "/api/get_all_products.php", true);
            xhr.send();
        };

        window.onload = () => {
            getAllProducts();
        };
    </script>

    <!-- Will convert to TS later. Just a proof of concept -->
    <!-- <script>

        // TODO: Function to handle card templates (with built-in carousel)

        // JavaScript (DOM Manipulation) with XML
        const populateCatalog = (xmlDoc) => {
            const catalog = document.getElementById("catalog");
            catalog.innerHTML = ""; // Clears catalog

            let products = xmlDoc.getElementsByTagName("product");
            for (let i = 0; i < products.length; i++) {
                let productName = products[i].getElementsByTagName("name")[0].childNodes[0].nodeValue;
                let productDesc = products[i].getElementsByTagName("desc")[0].childNodes[0].nodeValue.slice(0, 64) + "..."; // Includes a shortened version
                let productPrice = products[i].getElementsByTagName("price")[0].childNodes[0].nodeValue;

                let productImg = products[i].getElementsByTagName("img")[0].childNodes[0].nodeValue; // Selecting only 1 image for now

                const card = `
                    <div id="product-${i}" class="w-100 h-100 bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                            <img src="/api/get_image.php?imgName=${productImg}" alt="" class="w-full h-full object-cover" />
                        </div>

                        <div class="p-4">
                            <h1 class="text-lg font-bold text-gray-900 mb-1">${productName}</h1>
                            <h3 class="text-xl font-semibold text-green-600 mb-2">${productPrice}</h3>
                            <p class="text-sm text-gray-600">${productDesc}</p>
                        </div>
                    </div>
                `;

                // catalog.innerHTML += card;
            }
        };

        // AJAX with XML
        const getProductsAjax = () => {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () => {
                if ((xhr.readyState == 4) && (xhr.status == 200)) {
                    populateCatalog(xhr.responseXML);
                }
            };

            xhr.open("GET", "/api/get_all_products.php", true);
            xhr.send();
        };

        window.onload = () => {
            getProductsAjax();            
        };
    </script> -->
</body>
</html>