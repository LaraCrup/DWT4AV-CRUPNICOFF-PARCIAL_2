document.addEventListener('DOMContentLoaded', function() {
    const filterInputs = document.querySelectorAll(
        'input[name="categoria"], input[name="precio-max"], input[name="valoracion"]'
    );
    const precioMaxInput = document.getElementById('precio-max');
    const productCards = document.querySelectorAll('.productCard, .cakeCard');

    function getUrlParams() {
        const params = new URLSearchParams(window.location.search);
        return {
            categoria: params.get('categoria'),
            precio: params.get('precio'),
            valoracion: params.get('valoracion')
        };
    }

    function applyUrlFilters() {
        const params = getUrlParams();
        let hasFilters = false;

        if (params.categoria) {
            const categoryCheckbox = document.querySelector(
                `input[name="categoria"][value="${params.categoria}"]`
            );
            if (categoryCheckbox) {
                categoryCheckbox.checked = true;
                hasFilters = true;
            }
        }

        if (params.precio) {
            precioMaxInput.value = params.precio;
            document.getElementById('precio-max-value').textContent = params.precio;
            hasFilters = true;
        }

        if (params.valoracion) {
            const ratingCheckbox = document.querySelector(
                `input[name="valoracion"][value="${params.valoracion}"]`
            );
            if (ratingCheckbox) {
                ratingCheckbox.checked = true;
                hasFilters = true;
            }
        }

        if (hasFilters) {
            const filtersContent = document.getElementById('filters-content');
            if (filtersContent) {
                filtersContent.classList.add('show');
            }
        }
    }

    function applyFilters() {
        const selectedCategories = Array.from(
            document.querySelectorAll('input[name="categoria"]:checked')
        ).map(input => parseInt(input.value));

        const maxPrice = parseInt(precioMaxInput.value);

        const selectedRatings = Array.from(
            document.querySelectorAll('input[name="valoracion"]:checked')
        ).map(input => ({
            value: input.value,
            min: parseInt(input.dataset.min)
        }));

        productCards.forEach(card => {
            let show = true;

            if (selectedCategories.length > 0) {
                const cardCategory = parseInt(card.dataset.category);
                if (!selectedCategories.includes(cardCategory)) {
                    show = false;
                }
            }

            if (show) {
                const cardPrice = parseInt(card.dataset.price);
                if (cardPrice > maxPrice) {
                    show = false;
                }
            }

            if (show && selectedRatings.length > 0) {
                const cardRating = parseInt(card.dataset.rating);
                const ratingMatches = selectedRatings.some(
                    rating => cardRating >= rating.min
                );
                if (!ratingMatches) {
                    show = false;
                }
            }

            card.style.display = show ? 'flex' : 'none';
        });

        checkNoProducts();
    }

    function checkNoProducts() {
        const visibleCards = Array.from(productCards).filter(
            card => card.style.display !== 'none'
        );

        let noProductsDiv = document.querySelector('.noProducts');

        if (visibleCards.length === 0) {
            if (!noProductsDiv) {
                noProductsDiv = document.createElement('div');
                noProductsDiv.className = 'noProducts';
                noProductsDiv.innerHTML = '<p class="fontTitle">No hay tortas disponibles con los filtros seleccionados</p>';
                document.getElementById('products').appendChild(noProductsDiv);
            }
            noProductsDiv.style.display = 'block';
        } else {
            if (noProductsDiv) {
                noProductsDiv.style.display = 'none';
            }
        }
    }

    filterInputs.forEach(input => {
        input.addEventListener('change', applyFilters);
        input.addEventListener('input', applyFilters);
    });

    applyUrlFilters();

    applyFilters();
});
