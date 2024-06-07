const apiKey = "bUke0SUO";
const apiEndpoint =
  "https://api.rescuegroups.org/v5/public/animals/search/available/?limit=100";

fetch(apiEndpoint, {
  method: "POST",
  headers: {
    Authorization: apiKey,
    "Content-Type": "application/json",
  },
})
  .then((response) => {
    console.log("Response Status:", response.status);
    return response.json();
  })
  .then((data) => {
    console.log("Response Data:", data);
    const animals = data.data;
    displayData(animals);
  })
  .catch((err) => console.error("Fetch Error:", err));

function displayData(animals) {
  const container = document.querySelector("#container");

  animals.forEach((animal) => {
    const url = animal.attributes.url;
    const name = animal.attributes.name;
    const image = animal.attributes.pictureThumbnailUrl;

    if (url && name && image) {
      const li = document.createElement("li");
      const a = document.createElement("a");
      a.href = url;
      const figure = document.createElement("figure");

      const img = document.createElement("img");
      let newWidth = 300;
      let newImageUrl = image.replace(/width=\d+/, `width=${newWidth}`);
      img.src = newImageUrl;
      img.alt = animal.attributes.slug;
      figure.appendChild(img);

      const figcaption = document.createElement("figcaption");
      figcaption.textContent = name;
      figure.appendChild(figcaption);

      a.appendChild(figure);
      li.appendChild(a);
      li.classList.add("item");
      container.appendChild(li);
    }
  });

  const wall = new Freewall("#container");
  wall.reset({
    selector: ".item",
    animate: true,
    cellW: 230,
    cellH: "auto",
    onResize: function () {
      wall.fitWidth();
    },
  });
  wall.fitWidth();

  // Adjusts the height of the grid once all images are loaded
  const images = wall.container.find(".item img");
  let loadedImages = 0;

  function checkImagesLoaded() {
    loadedImages++;
    if (loadedImages === images.length) {
      wall.fitWidth();
      const loader = document.querySelector(".loader");
      loader.classList.add("fade-out");
    }
  }

  images.each(function () {
    const img = this;
    if (img.complete) {
      checkImagesLoaded();
    } else {
      img.addEventListener("load", checkImagesLoaded);
      img.addEventListener("error", checkImagesLoaded);
    }
  });
}
