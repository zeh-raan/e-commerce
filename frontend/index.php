<?php
session_start(); // For per user customization
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>File-based E-Commerce</title>

    <link rel="stylesheet" href="/frontend/css/output.css">
</head>

<body class="bg-slate-900 p-4">
    <header>
        <nav>
            <!-- Navigate the seas here! -->
        </nav>
    </header>

    <!-- Hero Section -->
    
    <!-- Main -->
    <section id="catalog">
        <ol id="products-here"></ol>
    </section>

    <!-- Footer -->
    <footer></footer>

    <script src="/frontend/dist/main.js"></script>

    <!-- Will convert to TS later. Just a proof of concept -->
    <script>

        // TODO: Function to handle card templates (with built-in carousel)

        // JavaScript (DOM Manipulation) with XML
        const populateCatalog = (xmlDoc) => {
            const catalog = document.getElementById("products-here");
            catalog.innerHTML = ""; // Clears catalog

            let products = xmlDoc.getElementsByTagName("product");
            for (let i = 0; i < products.length; i++) {
                let productName = products[i].getElementsByTagName("name")[0].childNodes[0].nodeValue;
                let productDesc = products[i].getElementsByTagName("desc")[0].childNodes[0].nodeValue.slice(0, 64) + "..."; // Includes a shortened version
                let productPrice = products[i].getElementsByTagName("price")[0].childNodes[0].nodeValue;

                let productImg = products[i].getElementsByTagName("img")[0].childNodes[0].nodeValue; // Selecting only 1 image for now

                const card = `
                    <div id="product-${i}" class="w-100 bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
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

                catalog.innerHTML += card;
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
    </script>
</body>
</html>