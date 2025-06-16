
  //our studio-slider
  
  let currentSlide = 0;
  const slides = document.querySelectorAll(".slide");

  function showSlide(index) {
    slides.forEach(slide => slide.classList.remove("active"));
    slides[index].classList.add("active");
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
  }

  // Auto-play every 4 seconds
  setInterval(nextSlide, 4000);

  // Initial display
  showSlide(currentSlide);


// service page


  document.querySelectorAll('.service-card').forEach(card => {
    card.addEventListener('click', () => {
      const details = card.querySelector('.service-details');
      details.classList.toggle('hidden');
    });
  });



  
