// This file handles all cart-related stuff
// i.e. Adding a product to cart, Removing a product from cart, etc...

let cart = [];
function loadCart() {
    cart = JSON.parse(localStorage.getItem("cart")) || [];
}

// Function that writes cart to localstorage
function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

// Function to add a product to cart
function addToCart(product_id) {
    try {
        
        // Increment quantity if product is already in cart
        let alreadyInCart = cart.find(prod => prod.product_id == product_id);
        if (alreadyInCart) {
            alreadyInCart.quantity++;
        }

        else {
            cart.push({ product_id: product_id, quantity: 1 });
        }

        saveCart();

    } catch (e) { 
        return;
    }
    
    return true; // Successfully added
}

// Function to remove an item from card
function removeFromCart(product_id) {
    try {
        // Decrement quantity if product is already in cart
        let alreadyInCart = cart.find(prod => prod.product_id == product_id);
        if (alreadyInCart && alreadyInCart.quantity != 1) {
            alreadyInCart.quantity--;
        }

        else {
            cart = cart.filter(prod => prod.product_id != product_id); // Removes product entirely
        }

        saveCart();

    } catch (e) { 
        return;
    }
    
    return true;
}

// Skips the decrementing stuff and just deletes the item from cart
function fullyRemoveFromCart(product_id) {
    try {
        cart = cart.filter(prod => prod.product_id != product_id); // Removes product entirely
        saveCart();

    } catch (e) { 
        return;
    }
    
    return true;
}

// Function mainly for cart
function changeQuantityInCart(product_id, amount) {
    try {
        // Decrement quantity if product is already in cart
        let alreadyInCart = cart.find(prod => prod.product_id == product_id);
        if (alreadyInCart) {
            alreadyInCart.quantity = amount;
            saveCart();
        }

        // If amount = 0, it will keep it in cart
        // We can do something about here then (Remove it or idk)

    } catch (e) { 
        return;
    }
    
    return true;
}

// Function to make life a bit easier
function getCart() {
    return cart;
}