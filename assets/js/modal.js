function modal() {
  // Get the modal
  const modal = document.getElementById("myModal");
  // Get the button that opens the modal
  const btns = document.querySelectorAll(".myBtn");
  // Get the <span> element that closes the modal
  const span = document.getElementById("close");

  btns.forEach((btn) => {
    btn.addEventListener("click", () => {
      modal.style.display = "flex";
    });
  });

  // When the user clicks on <span> (x), close the modal
  span.addEventListener("click", () => {
    console.log("click");
    modal.style.display = "none";
  });

  // When the user clicks anywhere outside of the modal, close it
  window.addEventListener("click", (event) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  modal();
});
