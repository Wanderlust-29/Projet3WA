// Function to handle the burger menu toggle
function burgerMenu() {
  const burger = document.getElementById("hamburger-icon");
  const navLinks = document.querySelector(".menu");

  // Toggle the burger menu and navigation links on click
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

// Function to handle the search button toggle
function search() {
  const searchBtns = document.querySelectorAll(".search-btn");
  const search = document.querySelector(".search");
  const btnClose = document.querySelector(".btn-close");

  // Toggle the search bar on each search button click
  searchBtns.forEach((searchBtn) => {
    searchBtn.addEventListener("click", () => {
      search.classList.toggle("closed");
    });
  });

  // Close the search bar on close button click
  btnClose.addEventListener("click", () => {
    search.classList.add("closed");
  });
}

// Function to handle the dark mode toggle
function darkMode() {
  const buttonDM = document.querySelector(".dark-mode-btn");
  const qualitySVG = document.querySelector(".quality");
  const socialSVG = document.querySelector(".social");
  const earthSVG = document.querySelector(".earth");

  // Check if dark mode is enabled in session storage
  let isDarkMode = sessionStorage.getItem("darkMode") === "true";
  console.log("Initial dark mode state:", isDarkMode);

  // Set initial mode based on session storage or default to false
  if (isDarkMode) {
    enableDarkMode();
  } else {
    disableDarkMode();
  }

  // Toggle dark mode and update session storage
  buttonDM.addEventListener("click", () => {
    if (document.body.classList.contains("dark")) {
      disableDarkMode();
      isDarkMode = false;
    } else {
      enableDarkMode();
      isDarkMode = true;
    }
    // Update session storage with current mode
    sessionStorage.setItem("darkMode", isDarkMode.toString());
  });

  // Function to enable dark mode
  function enableDarkMode() {
    document.body.classList.add("dark");
    document.body.classList.remove("light");
    buttonDM.innerText = "☀️"; // Change icon/text accordingly
    // Update other UI elements for dark mode if they exist
    if (qualitySVG) {
      qualitySVG.src = "assets/media/quality-dark-mode.svg";
    }
    if (socialSVG) {
      socialSVG.src = "assets/media/adopt-dark-mode.svg";
    }
    if (earthSVG) {
      earthSVG.src = "assets/media/earth-dark-mode.svg";
    }
  }

  // Function to disable dark mode
  function disableDarkMode() {
    document.body.classList.remove("dark");
    document.body.classList.add("light");
    buttonDM.innerText = "🌙"; // Change icon/text accordingly
    // Update other UI elements for light mode if they exist
    if (qualitySVG) {
      qualitySVG.src = "assets/media/quality.svg";
    }
    if (socialSVG) {
      socialSVG.src = "assets/media/adopt.svg";
    }
    if (earthSVG) {
      earthSVG.src = "assets/media/earth.svg";
    }
  }
}



// Initialize the functions when the DOM content is loaded
document.addEventListener("DOMContentLoaded", () => {
  burgerMenu();
  search();
  darkMode();
});
