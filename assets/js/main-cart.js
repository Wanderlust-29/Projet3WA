import { addToCart, incrementDecrement, changeShippingMethod } from "./cart.js";

document.addEventListener("DOMContentLoaded", () => {
  // Boutton ajouter au panier
  const addToCartButtons = document.querySelectorAll(".btn-add-to-cart");
  addToCartButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const article_id = button.dataset.article;
      addToCart(article_id);
    });
  });
  // Buttons increment/decrement
  document
    .querySelectorAll(".btn-increment, .btn-decrement")
    .forEach((button) => {
      button.addEventListener("click", function (event) {
        event.preventDefault();
        const articleId = this.getAttribute("data-article");
        const action = this.getAttribute("data-action");
        incrementDecrement(articleId, action);
      });
    });

  // Shipping Options
  const shippingOptions = document.querySelectorAll('input[name="drone"]');

  if (shippingOptions) {
    shippingOptions.forEach((radio) => {
      radio.addEventListener("change", function () {
        changeShippingMethod(this.value);
      });
    });
  }

  //désactive le boutton
  const btnCheckout = document.getElementById("checkout-button");
  btnCheckout.disabled = true;

  const radios = document.querySelectorAll('input[name="drone"]');
  radios.forEach((radio) => {
    radio.addEventListener("change", function () {
      if (this.checked) {
        btnCheckout.disabled = false;
      }
    });
  });

  document
    .getElementById("paymentForm")
    .addEventListener("submit", function (event) {
      let selected = false;
      for (const radio of radios) {
        if (radio.checked) {
          selected = true;
          break;
        }
      }
      if (!selected) {
        alert("Veuillez sélectionner une option de frais de port.");
        event.preventDefault(); // Empêche la soumission du formulaire de paiement
      }
    });
});
