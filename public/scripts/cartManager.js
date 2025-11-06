document.addEventListener('DOMContentLoaded', function () {
    const cartContainer = document.getElementById('cartItems');
    const emptyCartMessage = document.getElementById('emptyCartMessage');
    const checkoutSection = document.getElementById('checkoutSection');
    const totalElement = document.getElementById('total');
    const checkoutBtn = document.getElementById('checkoutBtn');

    loadCart();

    async function loadCart() {
        try {
            const response = await fetch('/api/cart/', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });

            const data = await response.json();
            displayCart(data.items, data.total);
        } catch (error) {
            console.error('Error cargando el carrito:', error);
        }
    }

    function displayCart(cart, total) {
        if (!cartContainer) return;

        cartContainer.innerHTML = '';

        if (Object.keys(cart).length === 0) {
            if (emptyCartMessage) emptyCartMessage.style.display = 'flex';
            if (checkoutSection) checkoutSection.style.display = 'none';
            return;
        }

        if (emptyCartMessage) emptyCartMessage.style.display = 'none';
        if (checkoutSection) checkoutSection.style.display = 'flex';

        Object.entries(cart).forEach(([itemKey, item]) => {
            const itemSubtotal = item.precio_unitario * item.cantidad;

            const cartItemElement = document.createElement('div');
            cartItemElement.className = 'cartItem fontBody';
            cartItemElement.innerHTML = `
                <div class="itemInfo">
                    <img src="/storage/products/${item.imagen}" alt="${item.nombre}">
                    <div class="itemDetails">
                        <h2>${item.nombre}</h2>
                        <p class="itemSize">${item.tamano_nombre}</p>
                    </div>
                </div>
                <div class="itemActions">
                    <div class="quantityControls">
                        <button class="quantityBtn decrease" data-item-key="${itemKey}">-</button>
                        <span class="quantity">${item.cantidad}</span>
                        <button class="quantityBtn increase" data-item-key="${itemKey}">+</button>
                    </div>
                    <p class="itemSubtotal">$${itemSubtotal.toFixed(2)}</p>
                </div>
                <button class="removeItem" data-item-key="${itemKey}">×</button>
            `;

            cartContainer.appendChild(cartItemElement);
        });

        if (totalElement) totalElement.textContent = `$${total.toFixed(2)}`;

        document.querySelectorAll('.quantityBtn.decrease').forEach(button => {
            button.addEventListener('click', () => {
                const itemKey = button.dataset.itemKey;
                const quantitySpan = button.nextElementSibling;
                const currentQuantity = parseInt(quantitySpan.textContent);

                if (currentQuantity > 1) {
                    updateQuantity(itemKey, currentQuantity - 1);
                } else {
                    removeItem(itemKey);
                }
            });
        });

        document.querySelectorAll('.quantityBtn.increase').forEach(button => {
            button.addEventListener('click', () => {
                const itemKey = button.dataset.itemKey;
                const quantitySpan = button.previousElementSibling;
                const currentQuantity = parseInt(quantitySpan.textContent);
                updateQuantity(itemKey, currentQuantity + 1);
            });
        });

        document.querySelectorAll('.removeItem').forEach(button => {
            button.addEventListener('click', () => {
                removeItem(button.dataset.itemKey);
            });
        });
    }

    async function removeItem(itemKey) {
        try {
            const response = await fetch('/api/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    item_key: itemKey
                })
            });

            const data = await response.json();
            if (data.success) {
                displayCart(data.cart, data.total);
                updateCartCountDisplay(data.itemCount);
            }
        } catch (error) {
            console.error('Error removiendo item:', error);
        }
    }

    async function updateQuantity(itemKey, newQuantity) {
        try {
            const response = await fetch('/api/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    item_key: itemKey,
                    cantidad: newQuantity
                })
            });

            const data = await response.json();
            if (data.success) {
                displayCart(data.cart, data.total);
                updateCartCountDisplay(data.itemCount);
            }
        } catch (error) {
            console.error('Error actualizando cantidad:', error);
        }
    }

    function updateCartCountDisplay(count) {
        const cartCountElements = document.querySelectorAll('.cartCount');
        cartCountElements.forEach(element => {
            element.textContent = count;
            if (count > 0) {
                element.style.display = 'flex';
            } else {
                element.style.display = 'none';
            }
        });
    }

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', async function(e) {
            e.preventDefault();

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                showMessage('Debes estar logueado para realizar una compra', 'error');
                window.location.href = '/login';
                return;
            }

            try {
                checkoutBtn.disabled = true;
                checkoutBtn.textContent = 'Procesando...';

                const response = await fetch('/compras', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({})
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    window.location.href = '/checkout';
                } else {
                    showMessage(data.message || 'Error al procesar la compra', 'error');
                    checkoutBtn.disabled = false;
                    checkoutBtn.textContent = 'Pagar';
                }
            } catch (error) {
                console.error('Error:', error);

                if (error.message && error.message.includes('401')) {
                    showMessage('Debes iniciar sesión para poder comprar.', 'error');
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 1500);
                } else {
                    showMessage('Error al procesar la compra. Por favor, intenta de nuevo.', 'error');
                }

                checkoutBtn.disabled = false;
                checkoutBtn.textContent = 'Pagar';
            }
        });
    }

    function showMessage(message, type = 'info') {
        const messageEl = document.createElement('div');
        messageEl.className = `message message-${type}`;
        messageEl.textContent = message;
        messageEl.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background-color: ${type === 'success' ? '#4CAF50' : '#f44336'};
            color: white;
            border-radius: 4px;
            z-index: 9999;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        `;

        document.body.appendChild(messageEl);

        setTimeout(() => {
            messageEl.remove();
        }, 3000);
    }
});
