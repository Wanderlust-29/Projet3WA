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
  fetch("index.php?route=delete-from-cart", options)
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

function changeShippingMethod(shippingMethod) {
  let formData = new FormData();

  formData.append("shipping-method", shippingMethod);
  fetch("index.php?route=update-shipping-costs", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      updateTotal(data);
    })
    .catch((error) => {
      console.error("Error changing shipping costs:", error);
    });
}

function updateCount(data) {
  const itemCount = Object.keys(data) ? Object.keys(data).length : 0;
  const cartCount = document.querySelector("[data-count]");
  console.log(cartCount);
  cartCount.innerText = itemCount;
}

function updateTotal(data) {
  console.log(data);
  let totalPrice = 0;

  // Parcourir les articles du panier
  for (const key in data) {
    if (Object.hasOwnProperty.call(data, key)) {
      const item = data[key];
      // Vérifier si l'élément est un article
      if (item.hasOwnProperty("price")) {
        totalPrice += item.price;
      }
    }
  }

  // Ajouter les frais de livraison au total
  if (
    data.hasOwnProperty("shipping_costs") &&
    data.shipping_costs.hasOwnProperty("price")
  ) {
    totalPrice += data.shipping_costs.price;
  }

  const cartTotalPrice = document.querySelector(".total-price");
  if (cartTotalPrice) {
    cartTotalPrice.textContent = totalPrice.toFixed(2) + "€";
  } else {
    console.error("Total price element not found.");
  }

  const btnCheckout = document.getElementById("checkout-button");
  if (totalPrice === 0) {
    btnCheckout.remove();
  }
}

export { addToCart, deleteFromCart, changeShippingMethod };
