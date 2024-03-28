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
  function gradeStar() {
    const grades = document.querySelectorAll(".grade");
    const averageGrade = document.querySelector(".average-grade");
    averageGradeInt = parseInt(averageGrade.textContent);
    let averageStars = "";
    for (let i = 0; i < averageGradeInt; i++) {
      averageStars += "⭐";
    }
    averageGrade.innerText = `${averageStars}`;
    grades.forEach((grade) => {
      const gradeInt = parseInt(grade.textContent);
      let stars = "";
      for (let i = 0; i < gradeInt; i++) {
        stars += "⭐";
      }
      grade.innerText = `${stars}`;
    });
  }
  burgerMenu();
  gradeStar();
});
