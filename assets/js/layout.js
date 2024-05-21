function burgerMenu() {
  const burger = document.getElementById("hamburger-icon");
  const navLinks = document.querySelector(".menu");
  const searchBtns = document.querySelectorAll(".search-btn");
  const search = document.querySelector(".search");

  burger.addEventListener("click", () => {
    burger.classList.toggle("active");
    search.classList.add("closed");
    navLinks.classList.toggle("active");
  });

  searchBtns.forEach((searchBtn) => {
    searchBtn.addEventListener("click", (event) => {
      navLinks.classList.remove("active");
      burger.classList.remove("active");
      search.classList.toggle("closed");
    });
  });
}
addEventListener("DOMContentLoaded", burgerMenu());
