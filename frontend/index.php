<?php
session_start(); // For per user customization
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>File-based E-Commerce</title>

    <link href="frontend/css/output.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
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
          <a href="#" class="hover:bg-gray-800 p-1 px-4 rounded-2xl transition-colors duration-300 font-medium">Home</a>
          <a href="#" class="hover:bg-gray-800 p-1 px-4 rounded-2xl transition-colors duration-300 font-medium">Catalog</a>
          <a href="#" class="hover:bg-gray-800 p-1 px-4 rounded-2xl transition-colors duration-300 font-medium">About Us</a>
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
    
    <!-- Layered Titles -->
    <div class="relative">
      <h2 id="hero-subtitle" class="text-2xl text-white font-bold mt-7 mr-20 opacity-0"></h2>
      <h1 id="hero-title" class="text-8xl font-extrabold text-white opacity-0 absolute left-1/2 -translate-x-1/2 -top-10 tracking-wide mix-blend-overlay"></h1>
    </div>

    <!-- Paragraph -->
    <p id="hero-desc" class="max-w-lg text-gray-100 text-base mt-12 opacity-0 transition-opacity duration-700">
      Discover products of the highest quality, tailored for your needs. Start your journey today.
    </p>

  </section>

  <img class="absolute opacity-40" src="/frontend/assets/icons/divider.svg">
  
  <!-- Main -->
  <section id="catalog"></section>

  <!-- Footer -->
  <footer></footer>

  <script src="/frontend/dist/main.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const subTitleEl = document.getElementById("hero-subtitle");
      const titleEl = document.getElementById("hero-title");
      const descEl = document.getElementById("hero-desc");

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
          }, 600);
        }
      }

      // Call animation
      typeSub();

      // // Reverse typing on scroll
      // window.addEventListener("scroll", () => {
      //   const scrollY = window.scrollY;
      //   if (scrollY > 100) {
      //     subTitleEl.style.opacity = 0;
      //     titleEl.style.opacity = 0;
      //     descEl.style.opacity = 0;
      //   } else {
      //     subTitleEl.style.opacity = 1;
      //     titleEl.style.opacity = 0.4;
      //     descEl.style.opacity = 1;
      //   }
      // });
    });
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