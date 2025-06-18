// Mock product data
const products = [
  {
    id: "1",
    name: "iPhone 15 Pro Max 256GB Natural Titanium",
    price: 1199,
    originalPrice: 1299,
    rating: 4.8,
    reviews: 2156,
    image: "📱",
    badge: "New",
    badgeType: "new",
    category: "Smartphones",
    brand: "apple",
    description:
      "Latest iPhone with titanium design, A17 Pro chip, and advanced camera system.",
  },
  {
    id: "2",
    name: "MacBook Pro 14-inch M3 Pro Chip",
    price: 1999,
    originalPrice: 2299,
    rating: 4.9,
    reviews: 1843,
    image: "💻",
    badge: "Hot",
    badgeType: "hot",
    category: "Laptops",
    brand: "apple",
    description: "Powerful laptop with M3 Pro chip for professional workflows.",
  },
  {
    id: "3",
    name: "AirPods Pro 2nd Generation with USB-C",
    price: 199,
    originalPrice: 249,
    rating: 4.7,
    reviews: 3241,
    image: "🎧",
    badge: "Sale",
    badgeType: "sale",
    category: "Audio",
    brand: "apple",
    description:
      "Premium wireless earbuds with active noise cancellation and spatial audio.",
  },
  {
    id: "4",
    name: "Apple Watch Ultra 2 GPS + Cellular",
    price: 799,
    rating: 4.6,
    reviews: 1567,
    image: "⌚",
    category: "Wearables",
    brand: "apple",
    description:
      "Rugged smartwatch designed for extreme sports and outdoor adventures.",
  },
  {
    id: "5",
    name: "Sony Alpha A7R V Mirrorless Camera",
    price: 3899,
    rating: 4.9,
    reviews: 892,
    image: "📷",
    badge: "Pro",
    badgeType: "new",
    category: "Cameras",
    brand: "sony",
    description:
      "Professional mirrorless camera with 61MP sensor and advanced autofocus.",
  },
  {
    id: "6",
    name: "PlayStation 5 Pro Console",
    price: 699,
    originalPrice: 799,
    rating: 4.8,
    reviews: 4521,
    image: "🎮",
    badge: "Limited",
    badgeType: "hot",
    category: "Gaming",
    brand: "sony",
    description:
      "Next-gen gaming console with enhanced performance and graphics.",
  },
  {
    id: "7",
    name: "Samsung Galaxy S24 Ultra 512GB",
    price: 1299,
    rating: 4.7,
    reviews: 1834,
    image: "📱",
    category: "Smartphones",
    brand: "samsung",
    description:
      "Premium Android smartphone with S Pen, advanced cameras, and AI features.",
  },
  {
    id: "8",
    name: "Dell XPS 13 Plus OLED Touchscreen",
    price: 1499,
    originalPrice: 1699,
    rating: 4.5,
    reviews: 756,
    image: "💻",
    badge: "Sale",
    badgeType: "sale",
    category: "Laptops",
    brand: "dell",
    description:
      "Ultra-premium laptop with stunning OLED display and modern design.",
  },
];

// State management
let currentFilters = {
  search: "",
  categories: [],
  brands: [],
  rating: [],
  priceMin: 0,
  priceMax: 5000,
  sort: "popularity",
};

let currentProducts = [...products];
let viewMode = "grid";

// DOM elements
const elements = {
  mobileMenuBtn: document.getElementById("mobileMenuBtn"),
  mobileMenu: document.getElementById("mobileMenu"),
  productsGrid: document.getElementById("productsGrid"),
  newsletterForm: document.getElementById("newsletterForm"),
  newsletterSuccess: document.getElementById("newsletterSuccess"),
  filterToggle: document.getElementById("filterToggle"),
  filtersSidebar: document.getElementById("filtersSidebar"),
  filtersClose: document.getElementById("filtersClose"),
  gridViewBtn: document.getElementById("gridViewBtn"),
  listViewBtn: document.getElementById("listViewBtn"),
  sortSelect: document.getElementById("sortSelect"),
  minPrice: document.getElementById("minPrice"),
  maxPrice: document.getElementById("maxPrice"),
  minPriceValue: document.getElementById("minPriceValue"),
  maxPriceValue: document.getElementById("maxPriceValue"),
  activeFilters: document.getElementById("activeFilters"),
  productsCount: document.getElementById("productsCount"),
  productSearch: document.getElementById("productSearch"),
  desktopProductSearch: document.getElementById("desktopProductSearch"),
};

// Carousel state
let currentSlide = 0;
let carouselInterval = null;

// Initialize the application
document.addEventListener("DOMContentLoaded", function () {
  initializeEventListeners();
  initializeCarousel();
  loadProducts();
  updatePriceDisplay();

  // Get URL parameters for category filtering
  const urlParams = new URLSearchParams(window.location.search);
  const category = urlParams.get("category");
  if (category) {
    filterByCategory(category);
  }
});

// Event listeners
function initializeEventListeners() {
  // Mobile menu toggle
  if (elements.mobileMenuBtn && elements.mobileMenu) {
    elements.mobileMenuBtn.addEventListener("click", toggleMobileMenu);
  }

  // Newsletter form
  if (elements.newsletterForm) {
    elements.newsletterForm.addEventListener("submit", handleNewsletterSubmit);
  }

  // Products page specific
  if (elements.filterToggle && elements.filtersSidebar) {
    elements.filterToggle.addEventListener("click", toggleFilters);
  }

  if (elements.filtersClose) {
    elements.filtersClose.addEventListener("click", closeFilters);
  }

  // View mode toggle
  if (elements.gridViewBtn && elements.listViewBtn) {
    elements.gridViewBtn.addEventListener("click", () => setViewMode("grid"));
    elements.listViewBtn.addEventListener("click", () => setViewMode("list"));
  }

  // Sort change
  if (elements.sortSelect) {
    elements.sortSelect.addEventListener("change", handleSortChange);
  }

  // Price range sliders
  if (elements.minPrice && elements.maxPrice) {
    elements.minPrice.addEventListener("input", handlePriceChange);
    elements.maxPrice.addEventListener("input", handlePriceChange);
  }

  // Search functionality
  if (elements.productSearch) {
    elements.productSearch.addEventListener("input", handleSearch);
  }
  if (elements.desktopProductSearch) {
    elements.desktopProductSearch.addEventListener("input", handleSearch);
  }

  // Filter checkboxes
  setupFilterCheckboxes();

  // Carousel controls
  const carouselPrev = document.getElementById("carouselPrev");
  const carouselNext = document.getElementById("carouselNext");

  if (carouselPrev) {
    carouselPrev.addEventListener("click", () => previousSlide());
  }

  if (carouselNext) {
    carouselNext.addEventListener("click", () => nextSlide());
  }

  // Carousel indicators
  document.querySelectorAll(".indicator").forEach((indicator, index) => {
    indicator.addEventListener("click", () => goToSlide(index));
  });

  // Click outside to close mobile menu
  document.addEventListener("click", function (event) {
    if (
      elements.mobileMenu &&
      !elements.mobileMenu.contains(event.target) &&
      !elements.mobileMenuBtn.contains(event.target) &&
      !elements.mobileMenu.classList.contains("hidden")
    ) {
      closeMobileMenu();
    }

    // Close filters on mobile when clicking outside
    if (
      elements.filtersSidebar &&
      window.innerWidth <= 1024 &&
      elements.filtersSidebar.classList.contains("open") &&
      !elements.filtersSidebar.contains(event.target) &&
      !elements.filterToggle.contains(event.target)
    ) {
      closeFilters();
    }
  });
}

// Mobile menu functions
function toggleMobileMenu() {
  if (elements.mobileMenu.classList.contains("hidden")) {
    openMobileMenu();
  } else {
    closeMobileMenu();
  }
}

function openMobileMenu() {
  elements.mobileMenu.classList.remove("hidden");
  document.body.style.overflow = "hidden";
}

function closeMobileMenu() {
  elements.mobileMenu.classList.add("hidden");
  document.body.style.overflow = "";
}

// Carousel functions
function initializeCarousel() {
  const carouselWrapper = document.getElementById("carouselWrapper");
  if (!carouselWrapper) return;

  // Start auto-play
  startCarouselAutoPlay();

  // Pause on hover
  const carouselSection = document.querySelector(".carousel-section");
  if (carouselSection) {
    carouselSection.addEventListener("mouseenter", stopCarouselAutoPlay);
    carouselSection.addEventListener("mouseleave", startCarouselAutoPlay);
  }

  // Handle touch events for mobile swipe
  let startX = 0;
  let endX = 0;

  carouselSection?.addEventListener("touchstart", (e) => {
    startX = e.touches[0].clientX;
  });

  carouselSection?.addEventListener("touchend", (e) => {
    endX = e.changedTouches[0].clientX;
    handleSwipe();
  });

  function handleSwipe() {
    const diffX = startX - endX;
    const threshold = 50;

    if (Math.abs(diffX) > threshold) {
      if (diffX > 0) {
        nextSlide();
      } else {
        previousSlide();
      }
    }
  }
}

function goToSlide(slideIndex) {
  const slides = document.querySelectorAll(".carousel-slide");
  const indicators = document.querySelectorAll(".indicator");

  if (!slides.length || !indicators.length) return;

  // Remove active class from current slide and indicator
  slides[currentSlide]?.classList.remove("active");
  indicators[currentSlide]?.classList.remove("active");

  // Update current slide
  currentSlide = slideIndex;

  // Add active class to new slide and indicator
  slides[currentSlide]?.classList.add("active");
  indicators[currentSlide]?.classList.add("active");

  // Reset auto-play timer
  stopCarouselAutoPlay();
  startCarouselAutoPlay();
}

function nextSlide() {
  const slides = document.querySelectorAll(".carousel-slide");
  const nextIndex = (currentSlide + 1) % slides.length;
  goToSlide(nextIndex);
}

function previousSlide() {
  const slides = document.querySelectorAll(".carousel-slide");
  const prevIndex = currentSlide === 0 ? slides.length - 1 : currentSlide - 1;
  goToSlide(prevIndex);
}

function startCarouselAutoPlay() {
  stopCarouselAutoPlay();
  carouselInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
}

function stopCarouselAutoPlay() {
  if (carouselInterval) {
    clearInterval(carouselInterval);
    carouselInterval = null;
  }
}

// Newsletter functions
function handleNewsletterSubmit(event) {
  event.preventDefault();
  const formData = new FormData(event.target);
  const email =
    formData.get("email") ||
    event.target.querySelector("input[type='email']").value;

  if (email) {
    // Simulate API call
    setTimeout(() => {
      elements.newsletterForm.classList.add("hidden");
      elements.newsletterSuccess.classList.remove("hidden");

      // Reset after 3 seconds
      setTimeout(() => {
        elements.newsletterForm.classList.remove("hidden");
        elements.newsletterSuccess.classList.add("hidden");
        event.target.reset();
      }, 3000);
    }, 500);
  }
}

// Product loading and rendering
function loadProducts() {
  if (!elements.productsGrid) return;

  // Show loading state
  elements.productsGrid.innerHTML =
    '<div class="loading"><div class="spinner"></div></div>';

  // Simulate API delay
  setTimeout(() => {
    renderProducts(currentProducts);
  }, 300);
}

function renderProducts(products) {
  if (!elements.productsGrid) return;

  if (products.length === 0) {
    elements.productsGrid.innerHTML = `
      <div class="no-products">
        <p>No products found matching your criteria.</p>
      </div>
    `;
    return;
  }

  const productsHTML = products
    .map((product) => createProductCard(product))
    .join("");

  elements.productsGrid.innerHTML = productsHTML;

  // Update products count
  if (elements.productsCount) {
    elements.productsCount.textContent = `Showing ${products.length} of ${currentProducts.length} products`;
  }

  // Add event listeners to product cards
  addProductEventListeners();
}

function createProductCard(product) {
  const discount = product.originalPrice
    ? Math.round(
        ((product.originalPrice - product.price) / product.originalPrice) * 100,
      )
    : 0;

  const badgeHTML = product.badge
    ? `<div class="product-card-badge badge-${product.badgeType}">${product.badge}</div>`
    : "";

  const discountHTML =
    discount > 0 ? `<div class="product-discount">-${discount}%</div>` : "";

  const originalPriceHTML = product.originalPrice
    ? `<span class="price-original">$${product.originalPrice.toLocaleString()}</span>`
    : "";

  const starsHTML = Array.from({ length: 5 }, (_, i) => {
    const filled = i < Math.floor(product.rating);
    return `<svg class="star ${filled ? "filled" : ""}" viewBox="0 0 24 24" ${filled ? 'fill="currentColor"' : 'fill="none" stroke="currentColor"'}>
      <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
    </svg>`;
  }).join("");

  return `
    <div class="product-card" data-product-id="${product.id}">
      <div class="product-card-image">
        <div class="product-visual">${product.image}</div>
        ${badgeHTML}
        ${discountHTML}
        <button class="product-wishlist" data-product-id="${product.id}">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="m12 21-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.18L12 21z"></path>
          </svg>
        </button>
        <div class="product-overlay">
          <button class="quick-view-btn" data-product-id="${product.id}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
            Quick View
          </button>
        </div>
      </div>
      <div class="product-info">
        <div class="product-category">${product.category}</div>
        <h3 class="product-name">${product.name}</h3>
        <div class="product-rating">
          <div class="stars">${starsHTML}</div>
          <span class="rating-text">(${product.reviews})</span>
        </div>
        <div class="product-price">
          <span class="price-current">$${product.price.toLocaleString()}</span>
          ${originalPriceHTML}
        </div>
        <button class="add-to-cart" data-product-id="${product.id}">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="m6 2 3 6"></path>
            <path d="M17 6H3a1 1 0 0 0-1 1v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7a1 1 0 0 0-1-1z"></path>
            <path d="m17 6 3 6"></path>
          </svg>
          Add to Cart
        </button>
      </div>
    </div>
  `;
}

function addProductEventListeners() {
  // Add to cart buttons
  document.querySelectorAll(".add-to-cart").forEach((button) => {
    button.addEventListener("click", (e) => {
      const productId =
        e.target.getAttribute("data-product-id") ||
        e.target.closest(".add-to-cart").getAttribute("data-product-id");
      addToCart(productId);
    });
  });

  // Wishlist buttons
  document.querySelectorAll(".product-wishlist").forEach((button) => {
    button.addEventListener("click", (e) => {
      e.stopPropagation();
      const productId =
        e.target.getAttribute("data-product-id") ||
        e.target.closest(".product-wishlist").getAttribute("data-product-id");
      toggleWishlist(productId);
    });
  });

  // Quick view buttons
  document.querySelectorAll(".quick-view-btn").forEach((button) => {
    button.addEventListener("click", (e) => {
      e.stopPropagation();
      const productId =
        e.target.getAttribute("data-product-id") ||
        e.target.closest(".quick-view-btn").getAttribute("data-product-id");
      openQuickView(productId);
    });
  });
}

// Product actions
function addToCart(productId) {
  const product = products.find((p) => p.id === productId);
  if (product) {
    // Simulate adding to cart
    console.log("Added to cart:", product.name);

    // Show notification (you could implement a toast notification here)
    alert(`${product.name} added to cart!`);

    // Update cart badge (assuming cart count increases)
    const cartBadge = document.querySelector(".cart-badge");
    if (cartBadge) {
      const currentCount = parseInt(cartBadge.textContent) || 0;
      cartBadge.textContent = currentCount + 1;
    }
  }
}

function toggleWishlist(productId) {
  const button = document.querySelector(
    `[data-product-id="${productId}"].product-wishlist`,
  );
  if (button) {
    button.classList.toggle("active");
    const product = products.find((p) => p.id === productId);
    if (product) {
      const action = button.classList.contains("active")
        ? "added to"
        : "removed from";
      console.log(`${product.name} ${action} wishlist`);
    }
  }
}

function openQuickView(productId) {
  const product = products.find((p) => p.id === productId);
  if (product) {
    // In a real app, this would open a modal with product details
    console.log("Quick view:", product.name);
    alert(
      `Quick view: ${product.name}\n\nPrice: $${product.price}\nRating: ${product.rating}/5\n\n${product.description}`,
    );
  }
}

// Filter functions
function toggleFilters() {
  if (elements.filtersSidebar) {
    elements.filtersSidebar.classList.toggle("open");
  }
}

function closeFilters() {
  if (elements.filtersSidebar) {
    elements.filtersSidebar.classList.remove("open");
  }
}

function setViewMode(mode) {
  viewMode = mode;

  if (elements.gridViewBtn && elements.listViewBtn) {
    elements.gridViewBtn.classList.toggle("active", mode === "grid");
    elements.listViewBtn.classList.toggle("active", mode === "list");
  }

  if (elements.productsGrid) {
    elements.productsGrid.className =
      mode === "grid" ? "products-grid" : "products-list";
  }
}

function handleSortChange(event) {
  currentFilters.sort = event.target.value;
  applyFilters();
}

function handlePriceChange() {
  if (elements.minPrice && elements.maxPrice) {
    currentFilters.priceMin = parseInt(elements.minPrice.value);
    currentFilters.priceMax = parseInt(elements.maxPrice.value);

    // Ensure min is not greater than max
    if (currentFilters.priceMin > currentFilters.priceMax) {
      const temp = currentFilters.priceMin;
      currentFilters.priceMin = currentFilters.priceMax;
      currentFilters.priceMax = temp;
      elements.minPrice.value = currentFilters.priceMin;
      elements.maxPrice.value = currentFilters.priceMax;
    }

    updatePriceDisplay();
    applyFilters();
  }
}

function updatePriceDisplay() {
  if (elements.minPriceValue && elements.maxPriceValue) {
    elements.minPriceValue.textContent = `$${currentFilters.priceMin.toLocaleString()}`;
    elements.maxPriceValue.textContent = `$${currentFilters.priceMax.toLocaleString()}`;
  }
}

function handleSearch(event) {
  currentFilters.search = event.target.value.toLowerCase();

  // Sync search across all search inputs
  const searchInputs = [
    elements.productSearch,
    elements.desktopProductSearch,
  ].filter(Boolean);
  searchInputs.forEach((input) => {
    if (input !== event.target) {
      input.value = event.target.value;
    }
  });

  applyFilters();
}

function setupFilterCheckboxes() {
  // Category filters
  document
    .querySelectorAll('.category-filters input[type="checkbox"]')
    .forEach((checkbox) => {
      checkbox.addEventListener("change", function () {
        const category = this.value;
        if (this.checked) {
          if (!currentFilters.categories.includes(category)) {
            currentFilters.categories.push(category);
          }
        } else {
          currentFilters.categories = currentFilters.categories.filter(
            (c) => c !== category,
          );
        }
        applyFilters();
      });
    });

  // Brand filters
  document
    .querySelectorAll('.brand-filters input[type="checkbox"]')
    .forEach((checkbox) => {
      checkbox.addEventListener("change", function () {
        const brand = this.value;
        if (this.checked) {
          if (!currentFilters.brands.includes(brand)) {
            currentFilters.brands.push(brand);
          }
        } else {
          currentFilters.brands = currentFilters.brands.filter(
            (b) => b !== brand,
          );
        }
        applyFilters();
      });
    });

  // Rating filters
  document
    .querySelectorAll('.rating-filters input[type="checkbox"]')
    .forEach((checkbox) => {
      checkbox.addEventListener("change", function () {
        const rating = parseInt(this.value);
        if (this.checked) {
          if (!currentFilters.rating.includes(rating)) {
            currentFilters.rating.push(rating);
          }
        } else {
          currentFilters.rating = currentFilters.rating.filter(
            (r) => r !== rating,
          );
        }
        applyFilters();
      });
    });
}

function filterByCategory(category) {
  // Check the appropriate category checkbox
  const categoryCheckbox = document.querySelector(`input[value="${category}"]`);
  if (categoryCheckbox) {
    categoryCheckbox.checked = true;
    currentFilters.categories = [category];
    applyFilters();
  }
}

function applyFilters() {
  let filteredProducts = [...products];

  // Apply search filter
  if (currentFilters.search) {
    filteredProducts = filteredProducts.filter(
      (product) =>
        product.name.toLowerCase().includes(currentFilters.search) ||
        product.category.toLowerCase().includes(currentFilters.search) ||
        product.brand.toLowerCase().includes(currentFilters.search),
    );
  }

  // Apply category filter
  if (currentFilters.categories.length > 0) {
    filteredProducts = filteredProducts.filter((product) =>
      currentFilters.categories.includes(product.category.toLowerCase()),
    );
  }

  // Apply brand filter
  if (currentFilters.brands.length > 0) {
    filteredProducts = filteredProducts.filter((product) =>
      currentFilters.brands.includes(product.brand.toLowerCase()),
    );
  }

  // Apply rating filter
  if (currentFilters.rating.length > 0) {
    filteredProducts = filteredProducts.filter((product) => {
      return currentFilters.rating.some(
        (minRating) => product.rating >= minRating,
      );
    });
  }

  // Apply price filter
  filteredProducts = filteredProducts.filter(
    (product) =>
      product.price >= currentFilters.priceMin &&
      product.price <= currentFilters.priceMax,
  );

  // Apply sorting
  filteredProducts = sortProducts(filteredProducts, currentFilters.sort);

  currentProducts = filteredProducts;
  renderProducts(currentProducts);
  updateActiveFilters();
}

function sortProducts(products, sortBy) {
  const sorted = [...products];

  switch (sortBy) {
    case "price-low":
      return sorted.sort((a, b) => a.price - b.price);
    case "price-high":
      return sorted.sort((a, b) => b.price - a.price);
    case "rating":
      return sorted.sort((a, b) => b.rating - a.rating);
    case "newest":
      return sorted.reverse(); // Assuming array order represents newness
    case "popularity":
    default:
      return sorted.sort((a, b) => b.reviews - a.reviews);
  }
}

function updateActiveFilters() {
  if (!elements.activeFilters) return;

  const activeFilterTags = [];

  // Price filter
  if (currentFilters.priceMin > 0 || currentFilters.priceMax < 5000) {
    activeFilterTags.push(
      `Price: $${currentFilters.priceMin} - $${currentFilters.priceMax}`,
    );
  }

  // Category filters
  currentFilters.categories.forEach((category) => {
    activeFilterTags.push(`Category: ${category}`);
  });

  // Brand filters
  currentFilters.brands.forEach((brand) => {
    activeFilterTags.push(`Brand: ${brand}`);
  });

  // Rating filters
  currentFilters.rating.forEach((rating) => {
    activeFilterTags.push(`${rating}+ stars`);
  });

  // Search filter
  if (currentFilters.search) {
    activeFilterTags.push(`Search: "${currentFilters.search}"`);
  }

  if (activeFilterTags.length === 0) {
    elements.activeFilters.innerHTML = "";
    return;
  }

  const filtersHTML = `
    <span class="filters-label">Active filters:</span>
    ${activeFilterTags
      .map(
        (tag) => `
      <span class="filter-tag">
        ${tag}
        <button onclick="removeFilter('${tag}')" type="button">×</button>
      </span>
    `,
      )
      .join("")}
  `;

  elements.activeFilters.innerHTML = filtersHTML;
}

function removeFilter(filterText) {
  // This is a simplified implementation
  // In a real app, you'd need more sophisticated filter removal logic
  console.log("Remove filter:", filterText);

  // For now, just clear all filters as an example
  currentFilters = {
    search: "",
    categories: [],
    brands: [],
    rating: [],
    priceMin: 0,
    priceMax: 5000,
    sort: "popularity",
  };

  // Reset form elements
  if (elements.minPrice) elements.minPrice.value = 0;
  if (elements.maxPrice) elements.maxPrice.value = 5000;
  if (elements.sortSelect) elements.sortSelect.value = "popularity";
  if (elements.productSearch) elements.productSearch.value = "";
  if (elements.desktopProductSearch) elements.desktopProductSearch.value = "";

  // Uncheck all checkboxes
  document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
    checkbox.checked = false;
  });

  updatePriceDisplay();
  applyFilters();
}

// Utility functions
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Performance optimization for search
const debouncedSearch = debounce(handleSearch, 300);

// Replace the direct search event listeners with debounced versions
if (elements.productSearch) {
  elements.productSearch.removeEventListener("input", handleSearch);
  elements.productSearch.addEventListener("input", debouncedSearch);
}
if (elements.desktopProductSearch) {
  elements.desktopProductSearch.removeEventListener("input", handleSearch);
  elements.desktopProductSearch.addEventListener("input", debouncedSearch);
}

// Handle window resize
window.addEventListener("resize", function () {
  // Close mobile menu on desktop
  if (
    window.innerWidth > 1024 &&
    elements.mobileMenu &&
    !elements.mobileMenu.classList.contains("hidden")
  ) {
    closeMobileMenu();
  }

  // Close filters sidebar on desktop
  if (
    window.innerWidth > 1024 &&
    elements.filtersSidebar &&
    elements.filtersSidebar.classList.contains("open")
  ) {
    closeFilters();
  }
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    const href = this.getAttribute("href");

    // Skip if href is just "#" or invalid
    if (!href || href === "#" || href.length <= 1) {
      return;
    }

    e.preventDefault();
    const target = document.querySelector(href);
    if (target) {
      target.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });
    }
  });
});

// Add loading state to buttons
function addLoadingToButton(button, duration = 1000) {
  const originalText = button.innerHTML;
  button.innerHTML = '<div class="spinner"></div>';
  button.disabled = true;

  setTimeout(() => {
    button.innerHTML = originalText;
    button.disabled = false;
  }, duration);
}

// Enhanced add to cart with loading state
function addToCart(productId) {
  const button = document.querySelector(
    `[data-product-id="${productId}"].add-to-cart`,
  );
  if (button) {
    addLoadingToButton(button);
  }

  const product = products.find((p) => p.id === productId);
  if (product) {
    setTimeout(() => {
      console.log("Added to cart:", product.name);

      // Update cart badge
      const cartBadge = document.querySelector(".cart-badge");
      if (cartBadge) {
        const currentCount = parseInt(cartBadge.textContent) || 0;
        cartBadge.textContent = currentCount + 1;
      }

      // Show success message
      showNotification(`${product.name} added to cart!`, "success");
    }, 1000);
  }
}

// Simple notification system
function showNotification(message, type = "info") {
  const notification = document.createElement("div");
  notification.className = `notification notification-${type}`;
  notification.style.cssText = `
    position: fixed;
    top: 20px;
    right: 20px;
    background: ${type === "success" ? "#10b981" : "#6366f1"};
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 10000;
    transform: translateX(100%);
    transition: transform 0.3s ease;
  `;
  notification.textContent = message;

  document.body.appendChild(notification);

  // Trigger animation
  setTimeout(() => {
    notification.style.transform = "translateX(0)";
  }, 100);

  // Remove notification
  setTimeout(() => {
    notification.style.transform = "translateX(100%)";
    setTimeout(() => {
      document.body.removeChild(notification);
    }, 300);
  }, 3000);
}

// Initialize everything when DOM is ready
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initializeEventListeners);
} else {
  initializeEventListeners();
}
