document.addEventListener("DOMContentLoaded", (event) => {
  function burgerMenu() {
    const burgerMenu = document.querySelector(".burger-menu");
    const btnBurger = document.querySelector(".btn-burger-menu");

    btnBurger.addEventListener("click", () => {
      burgerMenu.classList.toggle("close");
      burgerMenu.classList.toggle("open");
    });
  }
  burgerMenu();
});
