document.addEventListener("DOMContentLoaded", (event) => {
  function map() {
    const map = L.map("map").setView([48.25, -4.08], 11);
    let marker = L.marker([48.254588, -4.089867]).addTo(map);

    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
      attribution:
        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map);
  }
  map();
});
