document.addEventListener("DOMContentLoaded", (event) => {
  // Function to handle the burger menu
  function burgerMenu() {
    const btnDescription = document.querySelector(".btn-description");
    const btnIngredients = document.querySelector(".btn-ingredients");
    const description = document.querySelector(".description");
    const ingredients = document.querySelector(".ingredients");

    // Add event listener for the description button
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

    // Add event listener for the ingredients button
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

  // Function to handle the rating stars
  function gradeStar() {
    const grades = document.querySelectorAll(".grade");
    countComment = "";
    const averageGrade = document.querySelector(".average-grade");
    averageGradeInt = parseInt(averageGrade.textContent);
    let averageStars = "";

    // Generate stars for the average rating
    for (let i = 0; i < averageGradeInt; i++) {
      averageStars += "⭐";
    }

    // Generate stars for each rating comment
    grades.forEach((grade) => {
      const gradeInt = parseInt(grade.textContent);
      let stars = "";
      for (let i = 0; i < gradeInt; i++) {
        stars += "⭐";
      }
      countComment++;
      grade.innerText = `${stars} `;
    });
    // Display the average stars and the number of comments
    averageGrade.innerText = `${averageStars} (${countComment})`;
  }

  // Function to handle the cart animation
  function animationCart() {
    const cartButtons = document.querySelectorAll(".cart-button");

    // Add event listener for each cart button
    cartButtons.forEach((button) => {
      button.addEventListener("click", cartClick);
    });

    // Function called when a cart button is clicked
    function cartClick() {
      let button = this;
      button.classList.add("clicked");

      // Call a function to remove the class after 3 seconds
      removeClickedClass(button);
    }

    // Function to remove the "clicked" class after 3 seconds
    function removeClickedClass(button) {
      setTimeout(() => {
        button.classList.remove("clicked");
      }, 3000); // Remove the "clicked" class after 3 seconds
    }
  }

  // Call the functions
  animationCart();
  burgerMenu();
  gradeStar();
});
