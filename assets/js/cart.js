// Function to add an item to the cart
function addToCart(article_id) {
  let formData = new FormData();
  formData.append("article_id", article_id);

  const options = {
    method: "POST",
    body: formData,
  };

  fetch("/add-to-cart", options)
    .then((response) => response.json())
    .then((data) => {
      if (data.articles) {
        updateQuantity(data.articles);
        updateCount(data.articles);
        updateTotal(data.articles, data.shipping_costs);
        disableButtonArticle(data.articles);
        updateCartContent(data.articles); // Update page content
        Toastify({
          text: "Article ajouté au panier avec succès !",
          duration: 3000,
          close: true,
          gravity: "top",
          position: "right",
          backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
        }).showToast();
      } else {
        console.error("Invalid response structure:", data);
      }
    })
    .catch((error) => {
      console.error("Une erreur s'est produite lors de l'ajout de l'article au panier :", error);
    });
}

// Function to delete an item from the cart
function deleteFromCart(article_id, action) {
  let url = "/delete-from-cart";

  let formData = new FormData();
  formData.append("article_id", article_id);
  formData.append("action", action);

  const options = {
    method: "POST",
    body: formData,
  };

  fetch(url, options)
    .then((response) => response.json())
    .then((data) => {
      if (data.articles) {
        updateQuantity(data.articles);
        updateCount(data.articles);
        updateTotal(data.articles, data.shipping_costs);
        // Remove the item from the UI
        const item = document.querySelector(`.article[data-article="${article_id}"]`);
        if (item) {
          item.remove();
        }
        updateCartContent(data.articles);
        // Show Toastify notification
        Toastify({
          text: "Article supprimé du panier avec succès !",
          duration: 3000,
          close: true,
          gravity: "top",
          position: "right",
          background: "linear-gradient(to right, #00b09b, #96c93d)"
        }).showToast();
      } else {
        console.error("Invalid response structure:", data);
      }
    })
    .catch((error) => {
      console.error("Une erreur s'est produite lors de la suppression de l'article du panier :", error);
    });
}

// Function to increment/decrement the item quantity
function incrementDecrement(article_id, action) {
  let url = "/update-quantity";

  let formData = new FormData();
  formData.append("article_id", article_id);
  formData.append("action", action);

  const options = {
    method: "POST",
    body: formData,
  };

  fetch(url, options)
    .then((response) => response.json())
    .then((data) => {
      if (data.articles) {
        updateQuantity(data.articles);
        updateCount(data.articles);
        updateTotal(data.articles, data.shipping_costs);
        disableIncrement(data.articles);
        updateCartContent(data.articles);
      } else {
        console.error("Invalid response structure:", data);
      }
    })
    .catch((error) => {
      console.error("Une erreur s'est produite lors de la mise à jour de la quantité :", error);
    });
}

// Function to change the shipping method
function changeShippingMethod(shippingMethod) {
  let formData = new FormData();
  formData.append("shipping-method", shippingMethod);

  fetch("/update-shipping-costs", {
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
      updateTotal(data.articles, data.shipping_costs);

      // Show Toastify notification
      Toastify({
        text: "Méthode de livraison mise à jour.",
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        background: "linear-gradient(to right, #00b09b, #96c93d)",
      }).showToast();
    })
    .catch((error) => {
      console.error("Error changing shipping costs:", error);

      // Show error Toastify notification
      Toastify({
        text: "Erreur lors du changement de la méthode de livraison.",
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        background: "linear-gradient(to right, #ff5f6d, #ffc371)",
      }).showToast();
    });
}

// Update the quantity of items
function updateQuantity(articles) {
  let articlesArray = Object.values(articles);
  articlesArray.forEach((article) => {
    let quantity = article.quantity;

    let quantityElements = document.querySelectorAll(`.quantity[data-article="${article.id}"]`);
    quantityElements.forEach((quantityElement) => {
      if (quantityElement) {
        quantityElement.textContent = quantity;
      } else {
        console.error(`Quantity element not found for article ID: ${article.id}`);
      }
    });
  });
}

// Update the item counts
function updateCount(articles) {
  let articlesArray = Object.values(articles);
  let itemCount = 0;
  articlesArray.forEach((article) => {
    itemCount += article.quantity;
  });
  const cartCounts = document.querySelectorAll("[data-count]");
  if (cartCounts) {
    cartCounts.forEach((cartCount) => {
      cartCount.setAttribute("data-count", itemCount);
    });
  }
}

// Update the total price
function updateTotal(articles, shipping_costs) {
  let totalPrice = 0;

  for (const key in articles) {
    if (articles.hasOwnProperty(key)) {
      const item = articles[key];
      if (item.hasOwnProperty("price") && item.hasOwnProperty("quantity")) {
        totalPrice += item.price * item.quantity;
      }
    }
  }

  if (shipping_costs && shipping_costs.hasOwnProperty("price")) {
    totalPrice += shipping_costs.price;
  }

  const cartsTotalPrice = document.querySelectorAll(".total-price");
  cartsTotalPrice.forEach((cartTotalPrice) => {
    if (cartTotalPrice) {
      cartTotalPrice.textContent = totalPrice.toFixed(2) + "€";
    } else {
      console.error("Total price element not found.");
    }
  });

  const btnCheckout = document.getElementById("checkout-button");
  if (btnCheckout) {
    if (totalPrice === 0) {
      btnCheckout.style.display = "none";
    } else {
      btnCheckout.style.display = "block";
    }
  }
}

// Disable the button if the item is out of stock
function disableButtonArticle(articles) {
  let articlesArray = Object.values(articles);
  articlesArray.forEach((article) => {
    const cartButton = document.querySelector(`.cart-button[data-article="${article.id}"]`);
    const spanCart = document.getElementById("add");
    if (cartButton) {
      // Check if quantity exceeds stock
      if (article.quantity >= article.stock) {
        cartButton.classList.add("disabled");
        cartButton.disabled = true;
        if (spanCart) {
          spanCart.innerText = "Rupture de stock";
        }
      } else {
        cartButton.classList.remove("disabled");
        cartButton.disabled = false;
        if (spanCart) {
          spanCart.innerText = "Ajouter au panier";
        }
      }
    } else {
      console.error("Cart button not found for article ID: ", article.id);
    }
  });
}

// Disable the increment button if the item is out of stock
function disableIncrement(articles) {
  let articlesArray = Object.values(articles);
  articlesArray.forEach((article) => {
    const increment = document.querySelector(`.cart .btn-increment[data-article="${article.id}"]`);
    const outOfStock = document.querySelector(`.cart .out-of-stock[data-article="${article.id}"]`);

    if (increment && outOfStock) {
      // Check if quantity exceeds stock in the cart
      if (article.quantity >= article.stock) {
        increment.disabled = true;
        outOfStock.innerText = "Impossible d'ajouter un article (Rupture de stock)";
        outOfStock.style.display = "flex";
        outOfStock.style.justifyContent = "center";
      } else {
        increment.disabled = false;
        outOfStock.innerText = "";
        outOfStock.style.display = "none";
      }
    } else {
      console.error("Cart button or out-of-stock message not found for article ID: ", article.id);
    }
  });
}


// Function to check if the cart is empty
function isCartEmpty(articles) {
  let articlesArray = Object.values(articles);
  let itemCount = articlesArray.reduce((total, article) => total + article.quantity, 0);
  return itemCount === 0;
}

// Function to update the page content
function updateCartContent(articles) {
  const mainContent = document.getElementById('content');
  if (isCartEmpty(articles)) {
    mainContent.innerHTML = `
      <section class="cart-payement">
        <h1>Mon panier est vide...</h1>
        <p>Vous souhaitez passer à la caisse sans croquettes, jouets ou mastication pour vos amis à 4 pattes ? 😭😭😭</p>
        <a class="btn btn-cart-back" href="/">Revenir à la boutique</a>
      </section>
    `;
  } else {
    // Reload the page to update cart content
    location.reload();
  }
}

export { addToCart, deleteFromCart, incrementDecrement, changeShippingMethod };
