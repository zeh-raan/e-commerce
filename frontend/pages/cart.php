<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Cart</title>

    <!-- Tailwind CLI -->
    <link href="/css/output.css" rel="stylesheet">
</head>

<body>
    <?php include("components/header.php"); ?>

    <!-- Title text -->
    <div class="m-10 mb-0 mt-20">        
        <h1 class="w-full font-bold pl-4 pt-8 text-2xl">Shopping Cart</h1>
        <p id="cart-count" class="pl-4 pb-8 text-gray-600"></p>
    </div>

    <section class="section-layout mt-0">
        <div class="flex-1 bg-white rounded-2xl shadow-xl p-6">
            
            <!-- Column names -->
            <div class="grid grid-cols-[2fr_1fr_1fr_auto] items-center font-bold border-b-2 border-gray-200 pb-2">
                <p>Product</p>
                <p class="text-center">Price</p>
                <p class="text-center">Quantity</p>
                <p class="text-right pr-4">Delete</p>
            </div>
            
            <div id="cart-products" class="flex flex-col gap-4 mt-4"></div>
        </div>

        <!-- Summary -->
        <div class="bg-white w-64 p-6 rounded-2xl border border-gray-200 shadow-sm h-fit">
            <div class="space-y-4">
                <div class="font-semibold text-lg">
                    <p>Total: MUR <span id="total-price">0</span></p>
                </div>

                <div class="border-divider space-y-5">
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg cursor-pointer active:scale-95" onclick="window.location.href = '/checkout'">Checkout</button>
                    <button class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg cursor-pointer active:scale-95" onclick="clearCart(); renderCart();">Clear Cart</button>
                    <a href="/catalog" class="flex justify-center font-medium text-md text-blue-600 hover:underline">Continue Shopping</a>
                </div>
            </div>
        </div>
    </section>

    <?php include("components/footer.php"); ?>

    <script src="/js/cart.js"></script>
    <script>
        const cartProduct = document.getElementById("cart-products");
        const totalPriceMessage = document.getElementById("total-price");
        const cartCount = document.getElementById("cart-count");

        let totalCount = 0;
        let totalPrice = 0;

        function addToDisplay(xml) {
            let product = xml.getElementsByTagName("product")[0];

            let id = product.getAttribute("id");
            let category = product.getElementsByTagName("category")[0].childNodes[0].nodeValue;
            let name = product.getElementsByTagName("name")[0].childNodes[0].nodeValue;
            let price = product.getElementsByTagName("price")[0].childNodes[0].nodeValue;
            let img = product.getElementsByTagName("img")[0].childNodes[0].nodeValue;
            
            // Get quantiy from cart 
            quantity = cart.find(prod => prod.product_id == id).quantity;

            totalCount += Number(quantity);
            totalPrice += (quantity * Number(price));

            cartProduct.innerHTML += `
                <div class="grid grid-cols-[2fr_1fr_1fr_auto] items-center border-b border-gray-200 pb-2 gap-4">
                    <div class="flex items-center gap-4">
                        <img src="/api/get_image.php?imgName=${img}" class="w-30 h-30 object-cover rounded-xl">
                        <div>
                            <p class="text-gray-500 text-sm">${category}</p>
                            <h2 class="text-md font-semibold">${name}</h2>
                            <a href="/product/${id}" class="font-medium text-xs text-blue-600 hover:underline">Go to Product</a>
                        </div>
                    </div>
                    
                    <p class="text-center font-medium">MUR ${price}</p>
                    <input type="number" min="1" max="10" value="${quantity}" onchange="changeQuantityInCart('${id}', this.value); renderCart();" class="quantity-input w-16 mx-auto rounded-lg p-1 text-center focus:ring-0 focus:bg-transparent">

                    <div class="flex justify-end pr-4">
                        <button type="button" class="cursor-pointer hover:opacity-70 transition-all duration-200 delete-btn" onclick="fullyRemoveFromCart('${id}'); renderCart();">
                            <img src="/assets/icons/delete.svg" data-id="${id}" class="icon red-filter">
                        </button>
                    </div>
                </div>
            `;
        }

        // Helper function to just fetch details and return relevant strings
        function getProduct(product_id) {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () => {
                if ((xhr.readyState == 4) && (xhr.status == 200)) {
                    addToDisplay(xhr.responseXML);
                }
            };

            xhr.open("GET", "/api/get_product.php?prodId=" + product_id, false); // Let's not make it async
            xhr.send();
        }

        // Render cart UI
        function renderCart() {
            totalCount = 0;
            totalPrice = 0;

            cartProduct.innerHTML = "";

            getCart().forEach(item => {
                getProduct(item.product_id);
            });
            
            // Clearts display
            totalPriceMessage.innerText = "";
            cartCount.innerText = "";

            totalPriceMessage.innerText = totalPrice;
            cartCount.innerText = `You have ${totalCount} product${totalCount !== 1 ? "s" : ""} in your cart`;

            // attachEventListeners();
        }

        window.onload = () => {
            loadCart();
            renderCart();
        }        
    </script>
</body>
</html>