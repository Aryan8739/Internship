
// Carousel state
let currentSlide = 0;
let carouselInterval = 5000;


  
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
} // <-- Add this closing brace to end the DOMContentLoaded function
