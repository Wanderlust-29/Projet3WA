document.addEventListener("DOMContentLoaded", (event) => {
  // Supprimer le message d'erreur après 3 secondes
  setTimeout(function () {
    var errorMsg = document.getElementById("error-msg");
    if (errorMsg) {
      errorMsg.remove();
    }
  }, 3000);

  // Supprimer le message de succès après 3 secondes
  setTimeout(function () {
    var successMsg = document.getElementById("success-msg");
    if (successMsg) {
      successMsg.remove();
    }
  }, 3000);
});
