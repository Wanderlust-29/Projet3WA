function burgerMenu() {
  const burger = document.getElementById("hamburger-icon");
  const navLinks = document.querySelector(".menu");
  const searchBtns = document.querySelectorAll(".search-btn");
  const search = document.querySelector(".search");

  burger.addEventListener("click", () => {
    burger.classList.toggle("active");
    navLinks.classList.toggle("active");
  });

  // When the user clicks anywhere outside of the modal, close it
  window.addEventListener("click", (event) => {
    if (!navLinks.contains(event.target) && !burger.contains(event.target)) {
      navLinks.classList.remove("active");
      burger.classList.remove("active");
    }
  });

  searchBtns.forEach((searchBtn) => {
    searchBtn.addEventListener("click", () => {
      search.classList.toggle("closed");
    });
  });
}

// Ensure the function reference is passed to DOMContentLoaded
document.addEventListener("DOMContentLoaded", burgerMenu);
