import { addToCart, deleteFromCart, incrementDecrement, changeShippingMethod } from "./cart.js";

document.addEventListener("DOMContentLoaded", () => {
  // Boutton add-to-cart
  const addToCartButtons = document.querySelectorAll(".btn-add-to-cart");
  addToCartButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const article_id = button.dataset.article;
      addToCart(article_id);
    });
  });

  // Bouttons delete
  const deleteButtons = document.querySelectorAll(".remove-product");
  deleteButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const article_id = button.getAttribute("data-article");
      const action = button.getAttribute("data-action");
      console.log(action, article_id);
      deleteFromCart(article_id, action);
    });
  });


  // Buttons increment/decrement
  document.querySelectorAll(".btn-increment, .btn-decrement").forEach((button) => {
    button.addEventListener("click", function () {
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

  // If the quantity is < 1 button disabled
  const quantityElements = document.querySelectorAll('.quantity');
  quantityElements.forEach((quantityElement) => {
    const btnDecrement = document.querySelector(`.btn-decrement[data-article="${quantityElement.dataset.article}"]`);
    const btnIncrement = document.querySelector(`.btn-increment[data-article="${quantityElement.dataset.article}"]`);

    if (btnDecrement && btnIncrement && quantityElement) {
      let quantityInt = parseInt(quantityElement.textContent, 10);

      if (quantityInt > 1) {
        btnDecrement.disabled = false;
      } else {
        btnDecrement.disabled = true;
      }

      btnIncrement.addEventListener('click', () => {
        quantityInt++;
        quantityElement.textContent = quantityInt;
        if (quantityInt > 1) {
          btnDecrement.disabled = false;
        }
      });

      btnDecrement.addEventListener('click', () => {
        if (quantityInt > 1) {
          quantityInt--;
          quantityElement.textContent = quantityInt;
        }
        if (quantityInt <= 1) {
          btnDecrement.disabled = true;
        }
      });
    }
  });

  //If an option is not checked, it does not display the cart
  const checkoutButton = document.getElementById("checkout-button")
  const radios = document.querySelectorAll("input[type=radio]")

  radios.forEach(radio => {
    radio.addEventListener("click", () => {
      if (radio.checked) {
        checkoutButton.disabled = false
      } else {
        checkoutButton.disabled = true
      }
    })
  })
})
