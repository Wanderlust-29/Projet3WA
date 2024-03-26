import { addToCart, deleteFromCart } from "./cart.js";

document.addEventListener("DOMContentLoaded", () => {
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
      const articleListItem = button.closest("li");
      deleteFromCart(article_id);
      articleListItem.remove();
    });
  });
});
