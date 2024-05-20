function burgerMenu() {
  //   const burgerMenu = document.querySelector(".menu");
  //   const btnBurger = document.querySelector(".btn-burger-menu");

  const burger = document.getElementById("hamburger-icon");
  const navLinks = document.querySelector(".menu");
  const searchBtns = document.querySelectorAll(".search-btn");
  const search = document.querySelector(".search");

  burger.addEventListener("click", () => {
    navLinks.classList.toggle("active");
  });
  burger.addEventListener("click", () => {
    burger.classList.toggle("active");
    search.classList.toggle("menu-active");
  });
  searchBtns.forEach((searchBtn) => {
    searchBtn.addEventListener("click", () => {
      search.classList.toggle("closed");
      console.log("click");
    });
  });
}
addEventListener("DOMContentLoaded", burgerMenu());
