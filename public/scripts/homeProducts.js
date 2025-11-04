document.addEventListener('DOMContentLoaded', function() {
    // Define products directly in this file instead of using products.js
    const featuredCakes = [
      {
        "id": 1,
        "name": "Chocolate Clásica",
        "price": 8500,
        "image": "chocolate",
        "popularity": 5
      },
      {
        "id": 3,
        "name": "Cheesecake Frutos Rojos",
        "price": 8800,
        "image": "cheesecake",
        "popularity": 5
      },
      {
        "id": 7,
        "name": "Oreo Congelada",
        "price": 9100,
        "image": "torta-oreo",
        "popularity": 5
      },
      {
        "id": 10,
        "name": "Chocotorta",
        "price": 8000,
        "image": "chocotorta",
        "popularity": 5
      },
      {
        "id": 2,
        "name": "Red Velvet",
        "price": 9500,
        "image": "red-velvet",
        "popularity": 4
      }
    ];

    const slider = document.getElementById('cakesSlider');
    
    if (!slider) {
        console.error('Slider element not found');
        return;
    }
    
    slider.innerHTML = '';
    
    featuredCakes.forEach(cake => {
        const card = document.createElement('article');
        
        const stars = '★'.repeat(cake.popularity) + '☆'.repeat(5 - cake.popularity);
        
        card.innerHTML = `
          <div class="cakeCard fontBody carouselItem">
            <div class="imgCake">
                <img src="/storage/products/${cake.image}.webp" alt="${cake.name}">
            </div>
            <div class="infoCake">
              <div>
                  <h3>${cake.name}</h3>
                  <div class="stars">${stars}</div>
              </div>
              <div class="cakePrice">
                  <p><span>$${cake.price}</span> por porcion</p>
              </div>
              </div>
              <a href="/productDetail.html" class="btn btnPrimary" data-product-id="${cake.id}">Ver producto</a>
          </div>
              `;
        
        slider.appendChild(card);
    });

    console.log(`${featuredCakes.length} cakes loaded`);
});
