// article.js

function initArticlePage() {
  document.addEventListener("DOMContentLoaded", () => {
    animationCart();
    burgerMenu();
    gradeStar();
  });
}

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

function gradeStar() {
  const grades = document.querySelectorAll(".grade");
  let countComment = 0;
  const averageGrade = document.querySelector(".average-grade");
  const averageGradeInt = parseInt(averageGrade.textContent);
  let averageStars = "";

  for (let i = 0; i < averageGradeInt; i++) {
    averageStars += "⭐";
  }
  
  grades.forEach((grade) => {
    const gradeInt = parseInt(grade.textContent);
    let stars = "";
    for (let i = 0; i < gradeInt; i++) {
      stars += "⭐";
    }
    countComment++;
    grade.innerText = `${stars} `;
  });
  averageGrade.innerText = `${averageStars} (${countComment})`;
}

function animationCart() {
  const cartButtons = document.querySelectorAll(".cart-button");

  cartButtons.forEach((button) => {
    button.addEventListener("click", cartClick);
  });

  function cartClick() {
    let button = this;
    button.classList.add("clicked");

    // Appel à une fonction pour enlever la classe après 3 secondes
    removeClickedClass(button);
  }

  function removeClickedClass(button) {
    setTimeout(() => {
      button.classList.remove("clicked");
    }, 3000); // Supprimer la classe "clicked" après 3 secondes
  }
}


module.exports = {initArticlePage, burgerMenu, gradeStar, animationCart };

