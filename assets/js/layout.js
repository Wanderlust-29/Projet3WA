document.addEventListener("DOMContentLoaded", (event) => {
  function burgerMenu() {
    const burgerMenu = document.querySelector(".menu");
    const btnBurger = document.querySelector(".btn-burger-menu");

    btnBurger.addEventListener("click", () => {
      burgerMenu.classList.toggle("close");
      burgerMenu.classList.toggle("open");
    });    
    if(burgerMenu.classList.contains('open')){
      btnBurger.innerHTML= `<i class="fa-solid fa-xmark"></i>`;
    } else {
      btnBurger.innerHTML= `<i class="fa fa-bars"></i>`
    }

  }

  burgerMenu();
});
