function initCart() {
  // si la session storage n'existe pas la créer
  if (getCart() === null) {
    saveCart(fakeCart);
  }
  renderCart();
}

export { initCart };

//   récupérer l’état actuel du panier
function getCart() {
  return JSON.parse(sessionStorage.getItem("cart"));
}

//   sauvegarder dans le sessionStorage l’état actuel de notre panier
function saveCart($cart) {
  sessionStorage.setItem("cart", JSON.stringify($cart));
}

//   Faux panier
let fakeCart = {
  totalPrice: 59,
  itemCount: 3,
  items: [
    {
      id: 1,
      imageUrl:
        "https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/wow_classic_blueriver_12kg.jpg",
      price: 23,
      amount: 1,
    },
    {
      id: 2,
      imageUrl:
        "https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/wow_classic_blueriver_12kg.jpg",
      price: 59.99,
      amount: 1,
    },
    {
      id: 3,
      imageUrl:
        "https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/wow_classic_blueriver_12kg.jpg",
      price: 19,
      amount: 1,
    },
  ],
};

// afficher le panier
function renderCart() {
  // reçois le panier
  var $cart = getCart();

  // supprime l'ul
  var $productList = document.querySelector("main > main");
  var $ulToRemove = document.querySelector("main > main > ul");
  $productList.removeChild($ulToRemove);

  // creation d'un ul
  var $newUl = document.createElement("ul");

  // creation des li
  for (var i = 0; i < $cart.items.length; i++) {
    if ($cart.items[i].amount > 0) {
      var $item = $cart.items[i];
      var $li = document.createElement("li");
      $li.appendChild(createCartItem($item));
      $newUl.appendChild($li);
    }
  }

  $productList.appendChild($newUl);

  // mise a jour du prix total
  let $totalPrice = document.getElementById("cart-total-price");
  $totalPrice.innerText = "Total : " + $cart.totalPrice + " $";

  loadListeners();
}

//   créer les articles dans notre panier
function createCartItem($item) {
  var $containerSection = document.createElement("section");

  // creation des figures et des images
  var $figure = document.createElement("figure");
  var $img = document.createElement("img");
  $img.setAttribute("alt", "image du produit " + $item.id);
  $img.setAttribute("src", $item.imageUrl);
  $figure.appendChild($img);

  $containerSection.appendChild($figure);

  // creation des titre des articles
  let $productInfo = document.createElement("section");
  $productInfo.classList.add("cart-product-info");
  let $productName = document.createElement("h3");
  let $productNameContent = document.createTextNode(
    "Nom du produit " + $item.id
  );
  $productName.appendChild($productNameContent);
  $productInfo.appendChild($productName);

  $containerSection.appendChild($productInfo);

  // creation des actions des articles
  let $productActions = document.createElement("section");
  $productActions.classList.add("cart-product-actions");

  let $buttonsSection = document.createElement("section");

  let $removeButton = document.createElement("button");
  $removeButton.setAttribute("data-product-id", $item.id);
  $removeButton.classList.add("cart-btn");
  $removeButton.classList.add("cart-button-remove");
  let $minus = document.createTextNode("-");
  $removeButton.appendChild($minus);

  let $amountSpan = document.createElement("span");
  let $amountContent = document.createTextNode($item.amount);
  $amountSpan.appendChild($amountContent);

  let $addButton = document.createElement("button");
  $addButton.setAttribute("data-product-id", $item.id);
  $addButton.classList.add("cart-btn");
  $addButton.classList.add("cart-button-add");
  let $plus = document.createTextNode("+");
  $addButton.appendChild($plus);

  $buttonsSection.appendChild($removeButton);
  $buttonsSection.appendChild($amountSpan);
  $buttonsSection.appendChild($addButton);

  $productActions.appendChild($buttonsSection);

  let $productPrice = document.createElement("p");
  $productPrice.setAttribute("data-product-id", $item.id);
  $productPrice.classList.add("cart-product-price");

  let $productPriceSpan = document.createElement("span");
  let $productPriceSpanContent = document.createTextNode(
    "" + $item.amount * $item.price
  );
  $productPriceSpan.appendChild($productPriceSpanContent);

  let $currencyContent = document.createTextNode("$");

  $productPrice.appendChild($productPriceSpan);
  $productPrice.appendChild($currencyContent);

  $productActions.appendChild($productPrice);

  $containerSection.appendChild($productActions);

  return $containerSection;
}

//   permet d’augmenter de 1 la quantité d’un produit dans le panier
function addItem(event) {
  let $id = event.target.getAttribute("data-product-id");
  let $itemKey = findItem($id);
  let $cart = getCart();

  if ($itemKey !== null) {
    $cart.items[$itemKey].amount += 1;
    saveCart($cart);
    computeCartTotal();
    renderCart();
  }
}

//   met a jour le prix total du panier
function computeCartTotal() {
  let $cart = getCart();
  let $price = 0;

  for (var i = 0; i < $cart.items.length; i++) {
    $price += $cart.items[i].price * $cart.items[i].amount;
  }

  $cart.totalPrice = $price;
  saveCart($cart);
}
//   supprime du panier
function removeItem(event) {
  let $id = event.target.getAttribute("data-product-id");
  let $itemKey = findItem($id);
  let $cart = getCart();

  if ($itemKey !== null) {
    $cart.items[$itemKey].amount -= 1;
    saveCart($cart);
    computeCartTotal();
    renderCart();
  }
}
