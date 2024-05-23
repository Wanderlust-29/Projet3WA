// Ajoute au panier
function addToCart(article_id) {
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
      updateItems(data);
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
// Supprime du panier
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
//Change les frais de ports
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

function groupArticlesByName(articles) {
  const groupedArticles = {};

  articles.forEach((article) => {
    if (groupedArticles[article.name]) {
      groupedArticles[article.name].count += 1;
    } else {
      groupedArticles[article.name] = {
        name: article.name,
        price: article.price,
        count: 1,
      };
    }
  });

  return Object.values(groupedArticles);
}

function updateItems(data) {
  const groupedItems = groupArticlesByName(data);
  const ul = document.querySelector(".list-articles");
  ul.innerHTML = "";

  groupedItems.forEach((item) => {
    const li = document.createElement("li");
    li.className = "article";
    li.textContent = `${item.name} ${item.price}€ (x${item.count})`;

    const a = document.createElement("a");
    a.className = "btn-delete-from-cart";
    a.setAttribute("data-article", item.name);

    const i = document.createElement("i");
    i.className = "fa-solid fa-x";

    a.appendChild(i);
    li.appendChild(a);

    a.addEventListener("click", () => {
      const index = groupedItems.findIndex(
        (groupedItem) => groupedItem.name === item.name
      );
      if (index !== -1) {
        groupedItems.splice(index, 1);
        updateItems(groupedItems);
      }
    });

    ul.appendChild(li);
  });
}
// Mets a jour le compteur
function updateCount(data) {
  const itemCount = Object.keys(data).length;
  const cartCount = document.querySelector("[data-count]");
  if (cartCount) {
    cartCount.setAttribute("data-count", itemCount);
  }
}
// Mets a jour le prix total
function updateTotal(data) {
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
