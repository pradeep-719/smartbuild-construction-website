document.addEventListener("DOMContentLoaded", () => {
  const productGrid = document.getElementById("product-grid");
  const searchBox = document.getElementById("searchBox");
  const brandFilters = document.querySelectorAll(".brand-filter");
  const priceRange = document.getElementById("priceRange");
  const minPrice = document.getElementById("minPrice");
  const maxPrice = document.getElementById("maxPrice");
  const ratingFilters = document.querySelectorAll(".rating-filter");
  const sortSelect = document.getElementById("sort-select");

  // Fetch product data from PHP
  fetch("fetch_materials.php")
    .then(res => res.json())
    .then(data => {
      let products = data;

      function renderProducts(list) {
        productGrid.innerHTML = "";
        if (list.length === 0) {
          productGrid.innerHTML = "<p>No products found.</p>";
          return;
        }

        list.forEach(p => {
          const card = document.createElement("div");
          card.className = "product-card";
          card.innerHTML = `
            <img src="${p.image}" alt="${p.name}">
            <h4>${p.name}</h4>
            <p>Brand: ${p.brand}</p>
            <p>Price: ₹${p.price}</p>
            <p>Rating: ⭐${p.rating}</p>
            <button class="add-to-cart">Add to Cart</button>
          `;
          productGrid.appendChild(card);
        });
      }

      // Filter + Sort Logic
      function applyFilters() {
        let filtered = [...products];

        // Search
        const searchTerm = searchBox.value.toLowerCase();
        filtered = filtered.filter(p =>
          p.name.toLowerCase().includes(searchTerm)
        );

        // Brand
        const selectedBrands = Array.from(brandFilters)
          .filter(b => b.checked)
          .map(b => b.value);
        filtered = filtered.filter(p => selectedBrands.includes(p.brand));

        // Price
        const maxVal = parseInt(priceRange.value);
        filtered = filtered.filter(p => parseFloat(p.price) <= maxVal);

        // Rating
        const selectedRating = document.querySelector(
          ".rating-filter:checked"
        ).value;
        if (selectedRating > 0) {
          filtered = filtered.filter(p => p.rating >= selectedRating);
        }

        // Sort
        const sort = sortSelect.value;
        if (sort === "low") filtered.sort((a, b) => a.price - b.price);
        else if (sort === "high") filtered.sort((a, b) => b.price - a.price);

        renderProducts(filtered);
      }

      // Event listeners
      searchBox.addEventListener("input", applyFilters);
      brandFilters.forEach(b => b.addEventListener("change", applyFilters));
      ratingFilters.forEach(r => r.addEventListener("change", applyFilters));
      priceRange.addEventListener("input", () => {
        maxPrice.textContent = priceRange.value;
        applyFilters();
      });
      sortSelect.addEventListener("change", applyFilters);

      // Initial render
      renderProducts(products);
    })
    .catch(err => console.error("Error:", err));
});
