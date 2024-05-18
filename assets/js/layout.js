function burgerMenu() {
  //   const burgerMenu = document.querySelector(".menu");
  //   const btnBurger = document.querySelector(".btn-burger-menu");

  const burger = document.getElementById("hamburger-icon");
  const navLinks = document.querySelector(".menu");

  burger.addEventListener("click", () => {
    navLinks.classList.toggle("active");
    console.log("click");
  });
  burger.addEventListener("click", () => {
    burger.classList.toggle("active");
  });
}
addEventListener("DOMContentLoaded", burgerMenu());
