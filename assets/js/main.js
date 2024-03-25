import { addToCart, deleteFromCart } from "./cart.js";

document.addEventListener("DOMContentLoaded", () => {
  console.log("Le DOM est chargé.");

  const addToCartButtons = document.querySelectorAll(".btn-add-to-cart");
  addToCartButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const article_id = button.dataset.article;
      addToCart(article_id);
    });
  });
  const deleteFromCartButtons = document.querySelectorAll(
    ".btn-delete-from-cart"
  );
  deleteFromCartButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const article_id = button.dataset.article;
      deleteFromCart(article_id);
    });
  });
});
