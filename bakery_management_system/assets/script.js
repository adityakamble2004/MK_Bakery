let cart = JSON.parse(localStorage.getItem('cart')) || [];

document.addEventListener('DOMContentLoaded', () => {
    updateCartUI();
});

// Add to Cart Function
function addToCart(id, name, price) {
    let item = cart.find(product => product.id === id);
    if (item) {
        item.quantity += 1;
    } else {
        cart.push({ id, name, price, quantity: 1 });
    }
    saveAndUpdateCart();
}

// Remove from Cart Function
function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    saveAndUpdateCart();
}

// Update Cart UI
function updateCartUI() {
    let cartList = document.getElementById('cart-items');
    let totalAmount = document.getElementById('cart-total');
    let cartIcon = document.getElementById('cart-count');
    cartList.innerHTML = '';
    let total = 0;
    let itemCount = 0;

    cart.forEach(item => {
        let li = document.createElement('li');
        li.innerHTML = `${item.name} (x${item.quantity}) - ₹${(item.price * item.quantity).toFixed(2)} 
        <button onclick="removeFromCart(${item.id})">❌</button>`;
        cartList.appendChild(li);
        total += item.price * item.quantity;
        itemCount += item.quantity;
    });
    totalAmount.innerText = `Total: ₹${total.toFixed(2)}`;
    cartIcon.innerText = itemCount;
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Save and Update Cart
function saveAndUpdateCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartUI();
}

// Show/Hide Floating Cart
function toggleCart() {
    let cartBox = document.getElementById('cart-box');
    cartBox.classList.toggle('hidden');
}
