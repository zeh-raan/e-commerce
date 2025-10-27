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
    <?php include("frontend/pages/components/header.php"); ?>

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

    <?php include("frontend/pages/components/footer.php"); ?>

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

            // Chooses five random products
            const randomIndices = [];
            while (randomIndices.length < 5) {
                let rnd = Math.floor(Math.random() * products.length);
                if (!randomIndices.includes(rnd)) {
                    randomIndices.push(rnd);
                }
            }

            const productDetails = [];
            for (let i = 0; i < randomIndices.length; i++) {
                productDetails.push(getProductDetails(products[randomIndices[i]]));
            }

            // TODO: Make this code better
            const featuredSectionHTML = `
                <div class="row-span-2 product-card group h-[calc(100%-20px)]">
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
</body>
</html>