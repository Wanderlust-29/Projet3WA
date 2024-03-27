function addToCart(article_id) {
  console.log(`Ajouter l'article ${article_id} au panier.`);

  let formData = new FormData();
  formData.append("article_id", article_id);

  // Options pour la requête fetch
  const options = {
    method: "POST",
    body: formData,
  };

  // Effectuer la requête fetch vers la route 'index.php?route=add-to-cart' avec les options définies
  fetch("index.php?route=add-to-cart", options)
    .then((response) => response.json()) // Analyser la réponse JSON
    .then((data) => {
      console.log(data); // Afficher les données renvoyées par le serveur dans la console
      updateCount(data);
      updateTotal(data);
    })
    .catch((error) => {
      console.error(
        "Une erreur s'est produite lors de l'ajout de l'article au panier :",
        error
      ); // Gérer les erreurs de la requête fetch
    });
}

function deleteFromCart(article_id) {
  let formData = new FormData();
  formData.append("article_id", article_id);

  // Options pour la requête fetch
  const options = {
    method: "POST",
    body: formData,
  };

  // Effectuer la requête fetch vers la route 'index.php?route=deleteFromCart' avec les options définies
  fetch("index.php?route=deleteFromCart", options)
    .then((response) => response.json())
    .then((data) => {
      console.log(data); // Afficher les données renvoyées par le serveur dans la console
      updateCount(data);
      updateTotal(data);
    })
    .catch((error) => {
      console.error(
        "Une erreur s'est produite lors de la suppression de l'article du panier :",
        error
      ); // Gérer les erreurs de la requête fetch
    });
}

function updateCount(data) {
  let count = Object.keys(data).length;
  const cartCount = document.querySelector(".cart-count");
  cartCount.innerText = count;
}
function updateTotal(data) {
  let totalPrice = 0;
  data.forEach((article) => {
    totalPrice += article.price;
  });
  const cartTotalPrice = document.querySelector(".total-price");
  cartTotalPrice.innerText = totalPrice.toFixed(2);
}

export { addToCart, deleteFromCart };
