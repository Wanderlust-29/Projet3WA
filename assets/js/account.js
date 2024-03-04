document.addEventListener("DOMContentLoaded", (event) => {
  function showArticles() {
    document.querySelectorAll(".order-articles").forEach((orderArticles) => {
      orderArticles.style.display = "none";
    });

    function toggleArticles(btnPlus) {
      const orderArticles = btnPlus.nextElementSibling;
      if (
        orderArticles.style.display === "none" ||
        orderArticles.style.display === ""
      ) {
        orderArticles.style.display = "block";
        btnPlus.innerText = "-";
      } else {
        orderArticles.style.display = "none";
        btnPlus.innerText = "+";
      }
    }

    document.querySelectorAll(".plus").forEach((btnPlus) => {
      btnPlus.addEventListener("click", () => {
        toggleArticles(btnPlus);
      });
    });
  }

  showArticles();
});
