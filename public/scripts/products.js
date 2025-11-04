document.querySelector('.filters button').addEventListener('click', function () {
  var content = document.getElementById('filters-content');
  if (content.style.display === 'none') {
    content.style.display = 'flex';
  } else {
    content.style.display = 'none';
  }
});

const products = [
  {
    "id": 1,
    "name": "Chocolate Clásica",
    "category": "chocolate",
    "price": 8500,
    "sizes": {
      "large": "12 porciones",
      "medium": "8 porciones",
      "small": "6 porciones",
      "slice": "1 porción"
    },
    "allergen_component": "gluten, egg, dairy",
    "image": "chocolate",
    "popularity": 5
  },
  {
    "id": 2,
    "name": "Red Velvet",
    "category": "clasicas",
    "price": 9500,
    "sizes": {
      "large": "14 porciones",
      "medium": "10 porciones",
      "small": "6 porciones",
      "slice": "1 porción"
    },
    "allergen_component": "gluten, dairy, colorants",
    "image": "red-velvet",
    "popularity": 4
  },
  {
    "id": 3,
    "name": "Cheesecake Frutos Rojos",
    "category": "frutales",
    "price": 8800,
    "sizes": {
      "large": "12 porciones",
      "medium": "8 porciones",
      "small": "4 porciones",
      "slice": "1 porción"
    },
    "allergen_component": "dairy, gluten, egg",
    "image": "cheesecake",
    "popularity": 5
  },
  {
    "id": 4,
    "name": "Lemon Pie",
    "category": "frutales",
    "price": 7200,
    "sizes": {
      "large": "10 porciones",
      "medium": "6 porciones",
      "small": "4 porciones",
      "slice": "1 porción"
    },
    "allergen_component": "gluten, egg, dairy",
    "image": "lemon-pie",
    "popularity": 3
  },
  {
    "id": 5,
    "name": "Selva Negra",
    "category": "chocolate",
    "price": 9700,
    "sizes": {
      "large": "14 porciones",
      "medium": "10 porciones",
      "small": "6 porciones",
      "slice": "1 porción"
    },
    "allergen_component": "gluten, egg, dairy",
    "image": "selva-negra",
    "popularity": 4
  },
  {
    "id": 6,
    "name": "Apple Crumble",
    "category": "frutales",
    "price": 6800,
    "sizes": {
      "large": "12 porciones",
      "medium": "8 porciones",
      "small": "6 porciones",
      "slice": "1 porción"
    },
    "allergen_component": "gluten, egg",
    "image": "torta-manzana",
    "popularity": 3
  },
  {
    "id": 7,
    "name": "Oreo Congelada",
    "category": "clasicas",
    "price": 9100,
    "sizes": {
      "large": "14 porciones",
      "medium": "10 porciones",
      "small": "6 porciones",
      "slice": "1 porción"
    },
    "allergen_component": "gluten, dairy, egg",
    "image": "torta-oreo",
    "popularity": 5
  },
  {
    "id": 8,
    "name": "Carrot Cake",
    "category": "clasicas",
    "price": 7600,
    "sizes": {
      "large": "12 porciones",
      "medium": "8 porciones",
      "small": "4 porciones",
      "slice": "1 porción"
    },
    "allergen_component": "gluten, nuts, egg",
    "image": "carrot-cake",
    "popularity": 4
  },
  {
    "id": 9,
    "name": "Mousse de Maracuyá",
    "category": "congeladas",
    "price": 10500,
    "sizes": {
      "large": "12 porciones",
      "medium": "8 porciones",
      "small": "6 porciones",
      "slice": "1 porción"
    },
    "allergen_component": "dairy, egg, gluten",
    "image": "maracuya",
    "popularity": 4
  },
  {
    "id": 10,
    "name": "Chocotorta",
    "category": "congeladas",
    "price": 8000,
    "sizes": {
      "large": "12 porciones",
      "medium": "8 porciones",
      "small": "6 porciones",
      "slice": "1 porción"
    },
    "allergen_component": "gluten, dairy",
    "image": "chocotorta",
    "popularity": 5
  }
]
  ;

const productsContainer = document.getElementById('products');

products.forEach(product => {
  const card = document.createElement('article');
  card.className = 'cakeCard fontBody carouselItem';

  const stars = '★'.repeat(product.popularity) + '☆'.repeat(5 - product.popularity);

  card.innerHTML = `
    <div class="imgCake">
        <img src="/storage/products/${product.image}.webp" alt="${product.name}">
    </div>
    <div class="infoCake">
      <div>
          <h3>${product.name}</h3>
          <div class="stars">${stars}</div>
      </div>
      <div class="cakePrice">
          <p><span>$${product.price}</span> por porcion</p>
      </div>
      </div>
      <a href="/products" class="btn btnPrimary">Ver producto</a>
  `;

  productsContainer.appendChild(card);
});
