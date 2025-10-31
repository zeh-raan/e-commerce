<?php
$prodId = $GLOBALS["prodId"];
// session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Product Page</title>

    <link rel="stylesheet" href="/css/output.css">
</head>

<body>
    <?php include("components/header.php"); ?>

    <section id="product-here" class="mt-30 w-screen h-fit mb-16">
        <h1 class="product-name w-fit m-auto text-center text-4xl font-bold px-4 pb-2 border-b-2 border-gray-200"></h1>
        <div id="product-display-container" class="grid grid-rows-1 grid-cols-2 px-8 py-8">
            <div id="product-images-carousel-container" class="m-4">
                <div id="product-images" class="w-full h-150">

                </div>

                <div id="carousel-btns">
                    <button type="button" id="img-prev" class="carousel-btn">←</button>
                    <button type="button" id="img-next" class="carousel-btn">→</button>
                </div>
            </div>

            <div id="product-details-container" class="p-4 h-full">
                <h4 id="product-category" class="text-sm font-medium text-blue-600 uppercase tracking-wide mb-4"></h4>
                <h2 class="product-name text-4xl font-bold text-gray-900"></h2>
                <h3 id="product-price" class="text-2xl font-semibold text-green-600 mb-6"></h3>

                <p id="product-desc" class="text-gray-600 text-md leading-relaxed mb-12"></p>

                <h3 class="text-gray-600 text-lg pb-2 border-gray-200 border-b-2">Details</h3>
                <div id="product-specifics-container" class="space-y-2 pt-4 mb-4"></div>

                <div id="product-action-btn-container" class="w-full h-fit flex flex-col gap-2">
                    <button id="add-to-cart-btn" class="flex-1 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg cursor-pointer active:scale-95">Add to Cart</button>
                    <button id="remove-from-cart-btn" class="hidden flex-1 w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg cursor-pointer active:scale-95">Remove from Cart</button>

                    <?php
                    if (isset($_SESSION["username"])) { // Also add "if user is an admin
                        echo '<button id="add-to-cart-btn" class="flex-1 w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg cursor-pointer active:scale-95">Edit</button>';
                    }
                    ?>
                </div>
                <p id="in-cart-message" class="p-4 text-center text-sm text-gray-400 italic"></p>
            </div>
        </div>
    </section>

    <?php include("components/footer.php"); ?>

    <script src="/js/cart.js"></script>
    <script>
        let currentImage = 0;
        const addToCartBtn = document.getElementById("add-to-cart-btn");
        const removeFromCartBtn = document.getElementById("remove-from-cart-btn");

        // Carousel logic
        function updateCarousel() {
            const carouselImages = document.getElementById("product-images");
            const translateX = -currentImage * 100;

            carouselImages.style.transform = `translateX(${translateX}%)`;
        }

        function changeImage(value) {
            const numOfImages = document.querySelectorAll("#product-images img").length; 
            currentImage = Math.abs((currentImage + value) % numOfImages);

            updateCarousel();
        }

        const displayProduct = (xml) => {

            // Getting node values (Just the basics for testing right now)
            let product = xml.getElementsByTagName("product")[0]; // Normally should be just one
            
            // Displaying category
            const catDisplay = document.getElementById("product-category")
            let category = product.getElementsByTagName("category")[0].childNodes[0].nodeValue;
            catDisplay.innerText = category;

            // Displaying name
            const nameDisplays = document.getElementsByClassName("product-name")
            let name = product.getElementsByTagName("name")[0].childNodes[0].nodeValue;

            for (let i = 0; i < nameDisplays.length; i++) {
                nameDisplays[i].innerText = name;
            };

            // Displaying description
            const descDisplay = document.getElementById("product-desc")
            let desc = product.getElementsByTagName("desc")[0].childNodes[0].nodeValue;
            descDisplay.innerText = desc;

            // Displaying price
            const priceDisplay = document.getElementById("product-price")
            let price = product.getElementsByTagName("price")[0].childNodes[0].nodeValue;
            priceDisplay.innerText = `MUR ${price}`;

            // Displaying details
            const productSpecificsContainer = document.getElementById("product-specifics-container");
            let details = product.getElementsByTagName("dt");

            for (let i = 0; i < details.length; i++) {
                productSpecificsContainer.innerHTML += `<div><h5>${details[i].getAttribute("name")}</h5><p>${details[i].childNodes[0].nodeValue}</p><div>`;
            }

            // Populates carousel
            const carouselImagesContainer = document.getElementById("product-images");
            let img = product.getElementsByTagName("img"); 

            // NOTE: Styling is in css/input.css
            for (let i = 0; i < img.length; i++) {
                carouselImagesContainer.innerHTML += `
                    <img src="/api/get_image.php?imgName=${img[i].childNodes[0].nodeValue}" />
                `;
            }

            const carouselBtnPrev = document.getElementById("img-prev");
            carouselBtnPrev.addEventListener("click", () => { changeImage(-1); });

            const carouselBtnNext = document.getElementById("img-next");
            carouselBtnNext.addEventListener("click", () => { changeImage(1); });
        };

        const getProductAjax = () => {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () => {
                if ((xhr.readyState == 4) && (xhr.status == 200)) {
                    displayProduct(xhr.responseXML);
                }
            };

            xhr.open("GET", "/api/get_product.php?prodId=<?php echo $prodId ?>", true);
            xhr.send();
        };

        function updateCartIndicator() {
            let prodInCart = getCart().find(prod => prod.product_id == "<?php echo $prodId ?>");
            if (prodInCart) {
                document.getElementById("in-cart-message").innerText = `${prodInCart.quantity} in cart!`;

                // Show "Remove from cart" button
                if (prodInCart.quantity > 0) {
                    removeFromCartBtn.classList.remove("hidden");
                    return;
                }

                // Hides "Remove from cart" button
                removeFromCartBtn.classList.add("hidden");
            }

            else {
                removeFromCartBtn.classList.add("hidden");
                document.getElementById("in-cart-message").innerText = `0 in cart!`;
            }
        }

        // Add to cart
        addToCartBtn.addEventListener("click", (e) => {
            if (addToCart("<?php echo $prodId ?>")) {
                updateCartIndicator();
            }
        });

        // Remove from cart
        removeFromCartBtn.addEventListener("click", (e) => {
            if (removeFromCart("<?php echo $prodId ?>")) {
                updateCartIndicator();
            }
        });

        window.onload = () => {
            loadCart();
            updateCartIndicator();

            getProductAjax();
            updateCarousel();
        };
    </script>
</body>
</html>