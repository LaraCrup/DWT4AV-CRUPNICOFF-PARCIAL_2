document.addEventListener('DOMContentLoaded', function() {
    let selectedSizeId = null;
    const addToCartBtn = document.getElementById('addToCart');
    const tortaId = addToCartBtn?.getAttribute('data-torta-id');

    // Cargar el contador del carrito desde el servidor
    loadCartCountFromServer();

    // Seleccionar el primer tamaño por defecto
    const firstSizeBtn = document.querySelector('.sizeBtn');
    if (firstSizeBtn) {
        firstSizeBtn.classList.add('selectedSize');
        selectedSizeId = firstSizeBtn.getAttribute('data-size-id');
    }

    // Manejar cambios de tamaño
    document.querySelectorAll('.sizeBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.sizeBtn').forEach(b => b.classList.remove('selectedSize'));
            this.classList.add('selectedSize');
            selectedSizeId = this.getAttribute('data-size-id');

            // Obtener el precio del tamaño seleccionado
            const price = this.getAttribute('data-price');

            // Actualizar el precio en la pantalla
            const priceElement = document.getElementById('priceDisplay');
            if (priceElement && price) {
                priceElement.textContent = '$' + parseFloat(price).toFixed(2);
            }
        });
    });

    // Manejar click en "Añadir al carrito"
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', async function() {
            if (!selectedSizeId) {
                alert('Por favor selecciona un tamaño');
                return;
            }

            if (!tortaId) {
                alert('Error: ID de la torta no encontrado');
                return;
            }

            try {
                const response = await fetch('/api/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        torta_id: tortaId,
                        tamano_id: selectedSizeId,
                        cantidad: 1
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Actualizar el contador del carrito
                    updateCartCount(data.itemCount);

                    // Mostrar mensaje de éxito
                    showMessage('Producto agregado al carrito', 'success');
                } else {
                    showMessage(data.message || 'Error al agregar el producto', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Error al agregar el producto', 'error');
            }
        });
    }

    // Función para actualizar el contador del carrito
    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cartCount');
        cartCountElements.forEach(element => {
            element.textContent = count;
            if (count > 0) {
                element.style.display = 'flex';
            }
        });
    }

    // Función para mostrar mensajes
    function showMessage(message, type = 'info') {
        // Crear elemento de mensaje
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

        // Remover el mensaje después de 3 segundos
        setTimeout(() => {
            messageEl.remove();
        }, 3000);
    }

    // Función para cargar el contador del carrito desde el servidor
    async function loadCartCountFromServer() {
        try {
            const response = await fetch('/api/cart/', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });

            const data = await response.json();
            let itemCount = 0;
            Object.values(data.items).forEach(item => {
                itemCount += item.cantidad;
            });
            updateCartCount(itemCount);
        } catch (error) {
            console.error('Error cargando el contador del carrito:', error);
        }
    }
});