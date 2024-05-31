document.addEventListener("DOMContentLoaded", (event) => {
  // Supprimer le message d'erreur après 3 secondes
  setTimeout(function () {
    const errorMsg = document.getElementById("error-msg");
    if (errorMsg) {
      errorMsg.remove();
    }
  }, 3000);

  // Supprimer le message de succès après 3 secondes
  setTimeout(function () {
    const successMsg = document.getElementById("success-msg");
    if (successMsg) {
      successMsg.remove();
    }
  }, 3000);
});
