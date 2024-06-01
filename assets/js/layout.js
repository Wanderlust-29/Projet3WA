function burgerMenu() {
  const burger = document.getElementById("hamburger-icon");
  const navLinks = document.querySelector(".menu");

  burger.addEventListener("click", () => {
    burger.classList.toggle("open");
    navLinks.classList.toggle("open");
  });

  // When the user clicks outside the menu, the menu closes
  window.addEventListener("click", (event) => {
    if (!navLinks.contains(event.target) && !burger.contains(event.target)) {
      navLinks.classList.remove("open");
      burger.classList.remove("open");
    }
  });
}

function search() {
  const searchBtns = document.querySelectorAll(".search-btn");
  const search = document.querySelector(".search");

  searchBtns.forEach((searchBtn) => {
    searchBtn.addEventListener("click", () => {
      search.classList.toggle("closed");
    });
  });
}

function darkMode() {
  const buttonDM = document.querySelector(".dark-mode-btn");

  buttonDM.addEventListener("click", () => {
    const body = document.body;
    const qualitySVG = document.querySelector(".quality");
    const socialSVG = document.querySelector(".social");
    const earthSVG = document.querySelector(".earth");
    if (body.classList.contains("dark")) {
      buttonDM.innerText = "🌙";
      body.classList.add("ligth");
      body.classList.remove("dark");
      qualitySVG.src = "assets/media/quality.svg";
      socialSVG.src = "assets/media/adopt.svg";
      earthSVG.src = "assets/media/earth.svg";
    } else {
      buttonDM.innerText = "☀️";
      body.classList.remove("ligth");
      body.classList.add("dark");
      qualitySVG.src = "assets/media/quality-dark-mode.svg";
      socialSVG.src = "assets/media/adopt-dark-mode.svg";
      earthSVG.src = "assets/media/earth-dark-mode.svg";
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  burgerMenu();
  search();
  darkMode();
});
