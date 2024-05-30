function burgerMenu() {
  const burger = document.getElementById("hamburger-icon");
  const navLinks = document.querySelector(".menu");

  burger.addEventListener("click", () => {
    burger.classList.toggle("active");
    navLinks.classList.toggle("active");
  });

  // When the user clicks outside the menu, the menu closes
  window.addEventListener("click", (event) => {
    if (!navLinks.contains(event.target) && !burger.contains(event.target)) {
      navLinks.classList.remove("active");
      burger.classList.remove("active");
    }
  });
}

function search(){
  const searchBtns = document.querySelectorAll(".search-btn");
  const search = document.querySelector(".search");

  searchBtns.forEach((searchBtn) => {
    searchBtn.addEventListener("click", () => {
      search.classList.toggle("closed");
    });
  });
}

function darkMode() {
  const buttonDM = document.querySelector(".dark-mode");
  buttonDM.addEventListener("click", () => {
    // Sélectionne tous les éléments de la page
    const allElements = document.querySelectorAll("*");

    // Parcourt chaque élément de la page
    allElements.forEach(element => {
      const computedStyle = window.getComputedStyle(element);
      const color = computedStyle.getPropertyValue("color");
      const bgColor = computedStyle.getPropertyValue("background-color");
  
      if (color === "rgb(0, 154, 135)") { 
        element.classList.toggle("color-DM");
        const beforeElement = window.getComputedStyle(element, "::before");
        const afterElement = window.getComputedStyle(element, "::after");
        if (beforeElement.content !== "none") {
          element.classList.toggle("color-DM-before");
        }
        if (afterElement.content !== "none") {
          element.classList.toggle("color-DM-after");
        }
      }
      if (bgColor === "rgb(0, 154, 135)") { 
        element.classList.toggle("background-color-DM");
      }
    });

    // Inverse la couleur du bouton lui-même
    buttonDM.classList.toggle("button-color-DM");
  });
}




document.addEventListener("DOMContentLoaded", () => {
  burgerMenu();
  search();
  darkMode();
});