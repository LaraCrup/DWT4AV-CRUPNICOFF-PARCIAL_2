let cartItems = [
    {
        id: 1,
        name: "Torta de Chocolate",
        price: 3500,
        quantity: 2,
        image: "chocolate"
    },
    {
        id: 2,
        name: "Cheesecake de Frutos Rojos",
        price: 4200,
        quantity: 1,
        image: "cheesecake"
    },
    {
        id: 3,
        name: "Red Velvet",
        price: 3200,
        quantity: 1,
        image: "red-velvet"
    }
];

document.addEventListener('DOMContentLoaded', function () {
    const mobileCartCount = document.getElementById('cartCount');
    const desktopCartCount = document.querySelector('.btnNav .cart .cartCount');

    const count = parseInt(localStorage.getItem('cartCount')) || 0;

    if (count > 0) {
        updateCountDisplay(count);
    }

    updateCartDisplay();
    updateCartCount();
    
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function(e) {
            clearCart();
        });
    }
    
    function updateCountDisplay(value) {
        if (mobileCartCount) {
            mobileCartCount.textContent = value;
            mobileCartCount.style.display = 'flex';
        }

        if (desktopCartCount) {
            desktopCartCount.textContent = value;
            desktopCartCount.style.display = 'flex';
        }
    }
});

function updateCartDisplay() {
    const cartContainer = document.getElementById('cartItems');
    const emptyCartMessage = document.getElementById('emptyCartMessage');
    const checkoutSection = document.getElementById('checkoutSection');
    const totalElement = document.getElementById('total');

    if (!cartContainer) return;

    cartContainer.innerHTML = '';

    if (cartItems.length === 0) {
        if (emptyCartMessage) emptyCartMessage.style.display = 'flex';
        if (checkoutSection) checkoutSection.style.display = 'none';
        return;
    }

    if (emptyCartMessage) emptyCartMessage.style.display = 'none';
    if (checkoutSection) checkoutSection.style.display = 'flex';

    let subtotal = 0;

    cartItems.forEach(item => {
        const itemSubtotal = item.price * item.quantity;
        subtotal += itemSubtotal;

        const cartItemElement = document.createElement('div');
        cartItemElement.className = 'cartItem fontBody';
        cartItemElement.innerHTML = `
            <div class="itemInfo">
                <img src="/storage/products/${item.image}.webp" alt="${item.name}">
                <div class="itemDetails">
                    <h2>${item.name}</h2>
                    <p class="itemSize">Porción</p>
                </div>
            </div>
            <div class="itemActions">
                <div class="quantityControls">
                    <button class="quantityBtn decrease" data-id="${item.id}">-</button>
                    <span class="quantity">${item.quantity}</span>
                    <button class="quantityBtn increase" data-id="${item.id}">+</button>
                </div>
                <p class="itemSubtotal">$${itemSubtotal}</p>
            </div>
            <button class="removeItem" data-id="${item.id}">×</button>
        `;

        cartContainer.appendChild(cartItemElement);
    });

    if (totalElement) totalElement.textContent = `$${subtotal}`;

    document.querySelectorAll('.quantityBtn.decrease').forEach(button => {
        button.addEventListener('click', () => decreaseQuantity(button.dataset.id));
    });

    document.querySelectorAll('.quantityBtn.increase').forEach(button => {
        button.addEventListener('click', () => increaseQuantity(button.dataset.id));
    });

    document.querySelectorAll('.removeItem').forEach(button => {
        button.addEventListener('click', () => removeItem(button.dataset.id));
    });
}

function increaseQuantity(itemId) {
    const item = cartItems.find(item => item.id == itemId);
    if (item) {
        item.quantity += 1;
        updateCartDisplay();
        updateCartCount();
    }
}

function decreaseQuantity(itemId) {
    const item = cartItems.find(item => item.id == itemId);
    if (item && item.quantity > 1) {
        item.quantity -= 1;
        updateCartDisplay();
        updateCartCount();
    } else if (item && item.quantity === 1) {
        removeItem(itemId);
    }
}

function removeItem(itemId) {
    cartItems = cartItems.filter(item => item.id != itemId);
    updateCartDisplay();
    updateCartCount();
}

function updateCartCount() {
    const totalItems = cartItems.reduce((total, item) => total + item.quantity, 0);
    const cartCountElements = document.querySelectorAll('.cartCount');

    cartCountElements.forEach(element => {
        element.textContent = totalItems;
    });
}

function clearCart() {
    cartItems = [];
    
    const cartCountElements = document.querySelectorAll('.cartCount');
    cartCountElements.forEach(element => {
        element.textContent = '0';
    });
    
    updateCartDisplay();
    
    localStorage.removeItem('cartItems');
    localStorage.setItem('cartCount', '0');
}
