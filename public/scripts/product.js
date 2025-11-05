        // Seleccionar el primer tamaño por defecto
        const firstSizeBtn = document.querySelector('.sizeBtn');
        if (firstSizeBtn) {
            firstSizeBtn.classList.add('selectedSize');
        }

        document.querySelectorAll('.sizeBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.sizeBtn').forEach(b => b.classList.remove('selectedSize'));
                this.classList.add('selectedSize');

                // Obtener el precio del tamaño seleccionado
                const price = this.getAttribute('data-price');

                // Actualizar el precio en la pantalla
                const priceElement = document.getElementById('priceDisplay');
                if (priceElement && price) {
                    priceElement.textContent = '$' + parseFloat(price).toFixed(2);
                }
            });
        });