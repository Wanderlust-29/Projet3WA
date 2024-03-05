document.addEventListener("DOMContentLoaded", (event) => {
  function burgerMenu() {
    const btnDescription = document.querySelector(".btn-description");
    const btnIngredients = document.querySelector(".btn-ingredients");
    const description = document.querySelector(".description");
    const ingredients = document.querySelector(".ingredients");

    btnDescription.addEventListener("click", () => {
      if (
        description.style.display === "none" ||
        description.style.display === ""
      ) {
        description.style.display = "block";
        ingredients.style.display = "none";
      } else {
        ingredients.style.display = "block";
        description.style.display = "none";
      }
    });
    btnIngredients.addEventListener("click", () => {
      if (
        ingredients.style.display === "none" ||
        ingredients.style.display === ""
      ) {
        ingredients.style.display = "block";
        description.style.display = "none";
      } else {
        description.style.display = "block";
        ingredients.style.display = "none";
      }
    });
  }
  burgerMenu();
});
