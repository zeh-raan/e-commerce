<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Cart</title>

    <!-- Tailwind CLI -->
    <link href="/frontend/css/output.css" rel="stylesheet">
</head>

<body>

    <!-- Navigation Bar -->
    <?php include("components/header.php"); ?>

    <!-- Heading -->
    <div class="m-10 mb-0 mt-20">        
        <h1 class="w-full font-bold p-4 text-2xl">Shopping Cart</h1>
        <p id="cart-count" class="p-4 text-gray-600"></p>
    </div>

    <section class="section-layout mt-0">
    
    <!-- Cart Layout -->
    <div class="flex-1 bg-white rounded-2xl shadow-xl p-6">
        
        <!-- Header -->
        <div class="grid grid-cols-[2fr_1fr_1fr_auto] items-center font-bold border-b-2 border-gray-200 pb-2">
            <p>Product</p>
            <p class="text-center">Price</p>
            <p class="text-center">Quantity</p>
            <p class="text-right pr-4">Delete</p>
        </div>
        
        <!-- Product container -->
        <div id="cart-products" class="flex flex-col gap-4 mt-4"></div>

    </div>

    <!-- Summary -->
    <div class="bg-white w-64 p-6 rounded-2xl border border-gray-200 shadow-sm h-fit">
        <div class="space-y-4">
            <button id="save-changes-btn" class="buttons">Save Changes</button>
            <div class="font-semibold text-lg border-divider">
                <p>Total: Rs<span id="total-price">0</span></p>
            </div>

            <div class="border-divider space-y-5">
                <button class="buttons"><a href="/frontend/pages/checkout.php">Checkout</a></button>
                <a href="/frontend/pages/catalog.php" class="flex justify-center hover:text-gray-500">Continue Shopping</a>
            </div>
        </div>

    </div>

    </section>

    <!-- Footer -->
    <?php include("components/footer.php"); ?>

    <script>
        const cartProduct = document.getElementById("cart-products");
        const totalPrice  = document.getElementById("total-price");
        const cartCount   = document.getElementById("cart-count");
        const saveBtn     = document.getElementById("save-changes-btn");

        let cart = [];

        async function loadCart() {
            const res     = await fetch("/backend/api/get_all_products.php");
            const xmlText = await res.text();
            const parser  = new DOMParser();
            const xml     = parser.parseFromString(xmlText, "application/xml");

            cart = []; // reset

            xml.querySelectorAll("category").forEach(category => {
                const categoryName = category.getAttribute("name");
                
                category.querySelectorAll("product").forEach(prod => {
                    const id       = prod.getAttribute("id");
                    const name     = prod.querySelector("name").textContent;
                    const price    = prod.querySelector("price").textContent;
                    const img      = prod.querySelector("img").textContent;
                    const detail   = prod.querySelector("dt").textContent;
                    const quantity = 1;

                    cart.push({ id, name, categoryName, price, img, detail, quantity });
                });
            });

            renderCart();
        }

        // Render cart UI
        function renderCart() {
            let total = 0;
            let cartHTML = "";

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;

                cartHTML += `
                        <div class="grid grid-cols-[2fr_1fr_1fr_auto] items-center border-b border-gray-200 pb-2 gap-4">

                        <div class="flex items-center gap-4">
                            <img src="/backend/data/images/${item.img}" class="w-30 h-30 object-cover rounded-xl">
                            <div>
                                <p class="text-gray-500 text-sm">${item.categoryName}</p>
                                <h2 class="text-md font-semibold">${item.name}</h2>
                                <p class="text-sm text-gray-500">Detail: <span class="font-bold">${item.detail}</span></p>
                            </div>
                        </div>
                        
                        <p class="text-center font-medium">Rs${item.price}</p>
                        <input type="number" min="1" max="10" value="${item.quantity}" data-id="${item.id}" class="quantity-input w-16 mx-auto border rounded-lg p-1 text-center">

                        <div class="flex justify-end pr-4">
                            <img src="/frontend/assets/icons/delete.svg" data-id="${item.id}" class="icon cursor-pointer hover:opacity-70 delete-btn">
                        </div>

                    </div>
                `;
            });

            cartProduct.innerHTML  = cartHTML;
            totalPrice.textContent = total;
            cartCount.textContent  = `You have ${cart.length} product${cart.length !== 1 ? "s" : ""} in your cart`;

            attachEventListeners();
        }

        // Attach listeners to dynamic elements
        function attachEventListeners() {
            document.querySelectorAll(".quantity-input").forEach(input => {
                input.addEventListener("input", e => {
                    const id = e.target.dataset.id;
                    const item = cart.find(p => p.id === id);
                    if (item) {
                        let val = parseInt(e.target.value) || 1;       
                        val = Math.min(Math.max(val, 1), 10);         
                        e.target.value = val;                         
                        item.quantity = val;                           
                    }
                });
            });

            document.querySelectorAll(".delete-btn").forEach(btn => {
                btn.addEventListener("click", e => {
                    const id = e.target.dataset.id;
                    cart = cart.filter(p => p.id !== id);
                    renderCart();
                });
            });
        }

        // Save changes button
        saveBtn.addEventListener("click", () => {
            let total = 0;
            cart.forEach(item => total += item.price * item.quantity);
            totalPrice.textContent = total;
            cartCount.textContent = `You have ${cart.length} product${cart.length !== 1 ? "s" : ""} in your cart`;
        });

        loadCart();
    </script>

</body>
</html>