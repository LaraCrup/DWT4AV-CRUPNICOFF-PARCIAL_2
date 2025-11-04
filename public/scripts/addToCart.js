document.addEventListener('DOMContentLoaded', function() {
    const addToCartBtn = document.getElementById('addToCart');
    const cartCount = document.getElementById('cartCount');
    const desktopCartLink = document.querySelector('.btnNav .cart');
    const desktopCartCount = desktopCartLink ? desktopCartLink.querySelector('.cartCount') : null;
    
    let count = parseInt(localStorage.getItem('cartCount')) || 0;
    
    if (count > 0) {
        updateCounterDisplay(count);
    }

    function updateCounterDisplay(value) {
        if (cartCount) {
            cartCount.textContent = value;
            cartCount.style.display = 'flex';
        }
        
        if (desktopCartCount) {
            desktopCartCount.textContent = value;
            desktopCartCount.style.display = 'flex';
        }
    }

    function updateCartCount() {
        count++;
        updateCounterDisplay(count);
        
        localStorage.setItem('cartCount', count);
    }

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            updateCartCount();
        });
    }
});
