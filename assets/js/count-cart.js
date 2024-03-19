fetch("api/get_cart.php")
  .then((response) => response.json())
  .then((data) => {
    console.log(data);
  });
