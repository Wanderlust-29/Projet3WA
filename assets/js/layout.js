document.addEventListener("DOMContentLoaded", (event) => {
  function burgerMenu() {
    const burgerMenu = document.querySelector(".menu");
    const btnBurger = document.querySelector(".btn-burger-menu");

    btnBurger.addEventListener("click", () => {
      burgerMenu.classList.toggle("close");
      burgerMenu.classList.toggle("open");
    });

    // Static menu
    let offset = burgerMenu.offsetHeight;
    window.onscroll = function () {
      if (window.innerWidth < 800 && burgerMenu.classList.contains("open")) {
        if (window.scrollY > offset - 10) {
          burgerMenu.classList.add("sticky");
        } else if (window.scrollY < offset - 20) {
          burgerMenu.classList.remove("sticky");
        }
      }
    };
  }

  burgerMenu();
});
