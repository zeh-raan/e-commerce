<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Checkout</title>

    <!-- Tailwind CLI -->
    <link href="/css/output.css" rel="stylesheet">
</head>
<body>
    
  <!-- Navigation Bar -->
  <?php include("components/header.php"); ?>

  <!-- Heading -->
  <div class="m-10 mb-0 mt-20">
    <h1 class="w-full font-bold p-4 text-2xl">Checkout</h1>
  </div>

  <section class="section-layout mt-0">
    <!-- CONTACT FORM -->
    <div class="section-content">
      <p class="py-4 text-gray-600 font-bold">Contact Information</p>

      <form id="checkout-form" class="space-y-6">
        <div class="grid grid-cols-2 gap-4">
          <!-- First Name -->
          <div class="flex flex-col">
            <label class="label-field">FIRST NAME</label>
            <input name="firstName" type="text" class="checkout-field" placeholder="Enter First Name" />
          </div>

          <!-- Last Name -->
          <div class="flex flex-col">
            <label class="label-field">LAST NAME</label>
            <input name="lastName" type="text" class="checkout-field" placeholder="Enter Last Name" />
          </div>

          <!-- Phone -->
          <div class="flex flex-col">
            <label class="label-field">PHONE</label>
            <input name="phone" type="text" class="checkout-field" placeholder="5xxxxxxx" />
          </div>

          <!-- Email -->
          <div class="flex flex-col">
            <label class="label-field">EMAIL</label>
            <input name="email" type="text" class="checkout-field" placeholder="xxxxxxx@gmail.com" />
          </div>
        </div>
      </form>

      <!-- DELIVERY METHOD -->
      <p class="p-4 text-gray-600 font-bold">Delivery Method</p>
      <div class="flex gap-4">
        <button id="store-btn" type="button" 
            class="flex items-center gap-2 bg-gray-200 border border-gray-500 p-3 rounded-2xl hover:bg-gray-300 transition-colors duration-300;">
          <img class="icon" src="/assets/icons/store.svg" alt="Store" /> Store Pickup
        </button>
      </div>

      <!-- Hidden Store Pickup Form -->
      <form id="store-form" class="hidden mt-6 space-y-4">
        <div class="flex flex-col">
          <label class="label-field">PICKUP DATE</label>
          <input name="pickupDate" type="date" class="checkout-field" />
        </div>

        <div class="flex flex-col">
          <label class="label-field">PICKUP TIME</label>
          <input name="pickupTime" type="time" class="checkout-field" />
        </div>

        <div class="flex flex-col">
          <label class="label-field">NOTES (optional)</label>
          <textarea name="notes" class="checkout-field" placeholder="Any instructions..."></textarea>
        </div>
      </form>
    </div>

    <!-- REVIEW CART -->
    <aside class="aside-layout">
      <div class="flex items-center justify-between p-4 cursor-pointer hover:text-gray-500 transition-colors duration-300" id="toggle-cart">
        <p class="font-bold pr-2">Review your cart</p>
        <img id="cart-arrow" class="icon transition-transform duration-300" src="/assets/icons/right.svg">
      </div>

      <div id="review-cart" class="p-4 space-y-3 transition-all duration-300 ease-in-out"></div>
      <div id="cart-footer" class="mt-4"></div>
    </aside>

    <!-- Popup and Overlay -->
    <div id="overlay"></div>
    <div id="popup">Checkout complete!</div>
  </section>

  <?php include("components/footer.php"); ?>

  <script src="/js/cart.js"></script>  
  <script>
    const $ = s => document.querySelector(s); // JUST WHY!???????
    
    const cartDisplayContainer = document.getElementById("review-cart");
    const cartTotalPriceIndicator = document.getElementById("cart-footer");

    /* ********** VALIDATION ********** */
    function showError(input, message = "") {
      let err = input.parentElement.querySelector(".error-text");
      if (!err) {
        err = document.createElement("p");
        err.classList.add("error-text");
        input.parentElement.appendChild(err);
      }
      err.textContent = message;
      if (message) input.classList.add("border-red-500");
      else input.classList.remove("border-red-500");
    }

    function validateForm(form) {
      let valid = true;

      form.querySelectorAll("input").forEach(input => {
        const name = input.name, value = input.value.trim();
        let msg = "";

        if (!value) msg = "This field is required.";
        else if (name === "email" && !/^[^@]+@[^@]+\.[^@]+$/.test(value))
          msg = "Enter a valid email.";
        else if (name === "phone" && !/^5\d{7}$/.test(value))
          msg = "Enter a valid phone number.";

        showError(input, msg);
        if (msg) valid = false;
      });

      return valid;
    }

    /* ********** LOAD CART ********** */
    async function displayCart() {
        let totalPrice = 0;
        cartDisplayContainer.innerHTML = "";
        cartTotalPriceIndicator.innerHTML = "";

        getCart().forEach(async (item) => {
            let res = await fetch("api/get_product.php?prodId=" + item.product_id);
            let xml = new DOMParser().parseFromString(await res.text(), "application/xml");

            let product = xml.getElementsByTagName("product")[0];
            let category = product.getElementsByTagName("category")[0].childNodes[0].nodeValue;
            let name = product.getElementsByTagName("name")[0].childNodes[0].nodeValue;
            let price = product.getElementsByTagName("price")[0].childNodes[0].nodeValue;
            let img = product.getElementsByTagName("img")[0].childNodes[0].nodeValue;

            totalPrice += (Number(price) * item.quantity);

            cartDisplayContainer.innerHTML += `
                <div class="flex justify-between items-center border-b border-gray-200 py-2">
                    <div class="flex items-center gap-4">
                        <img src="/api/get_image.php?imgName=${img}" class="w-16 h-16 rounded-xl object-cover" />
                        <div>
                            <p class="text-gray-500 text-sm">${category}</p>
                            <p class="font-semibold">${name}</p>
                        </div>
                    </div>
                    <p class="font-medium pl-4">MUR ${price}</p>
                </div>
            `;

            cartTotalPriceIndicator.innerHTML = `
                <div class="flex justify-between mt-4 font-bold text-lg border-t border-gray-300 pt-4">
                    <span>Total:</span><span>MUR ${totalPrice}</span>
                </div>
                <div class="mt-4">
                    <button id="done-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg cursor-pointer active:scale-95">Done</button>
                </div>
            `;
        });
    }

    /* ********** CART TOGGLE ********** */
    $("#toggle-cart").addEventListener("click", () => {
      $("#review-cart").classList.toggle("hidden");
      $("#cart-arrow").classList.toggle("rotate-90");
    });

    /* ********** DELIVERY TOGGLE ********** */
    $("#store-btn").addEventListener("click", () =>
      $("#store-form").classList.toggle("hidden")
    );

    /* ********** POPUP ********** */
    function showPopup(msg) {
      $("#popup").textContent = msg;
      $("#popup").classList.add("active");
      $("#overlay").classList.add("active");
      setTimeout(() => {
        $("#popup").classList.remove("active");
        $("#overlay").classList.remove("active");
      }, 2000);
    }

    /* ********** DONE BUTTON ********** */
    document.addEventListener("click", e => {
      if (e.target.id === "done-btn") {
        const validContact = validateForm($("#checkout-form"));
        const storeVisible = !$("#store-form").classList.contains("hidden");
        const validStore = storeVisible ? validateForm($("#store-form")) : true;

        if (validContact && validStore) {
          showPopup("Checkout complete! Thank you for your order.");
          $("#checkout-form").reset();
          $("#store-form").reset();
          $("#store-form").classList.add("hidden");
        }
      }
    });

    window.onload = () => {
        loadCart();
        displayCart();
    }
  </script>

</body>
</html>