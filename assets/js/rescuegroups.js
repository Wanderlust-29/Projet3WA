const apiKey = "bUke0SUO";

const apiEndpoint =
  "https://api.rescuegroups.org/v5/public/animals/search/available/";

fetch(apiEndpoint, {
  method: "POST",
  headers: {
    Authorization: apiKey,
    "Content-Type": "application/json",
  },
})
  .then((response) => response.json())
  .then((data) => {
    const animals = data.data;
    displayData(animals);
  })
  .catch((err) => console.error(err));

function displayData(animals) {
  const adoptSection = document.querySelector(".section-adopt");

  animals.forEach((animal) => {
    const url = animal.attributes.url;
    const name = animal.attributes.name;
    const image = animal.attributes.pictureThumbnailUrl;

    if (url && name && image) {
      const a = document.createElement("a");
      a.href = animal.attributes.url;
      const article = document.createElement("article");

      const h3 = document.createElement("h3");
      h3.textContent = animal.attributes.name;
      article.appendChild(h3);

      const img = document.createElement("img");
      img.src = animal.attributes.pictureThumbnailUrl;
      img.alt = animal.attributes.name;
      article.appendChild(img);

      a.appendChild(article);
      adoptSection.appendChild(a);
    }
  });
}
