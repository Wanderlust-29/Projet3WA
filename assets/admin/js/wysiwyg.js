document.addEventListener("DOMContentLoaded", function (event) {
  let wysiwyg = document.querySelector(".wysiwyg");
  if (wysiwyg !== null) {
    Wysi({ el: ".wysiwyg" });
  }
});
