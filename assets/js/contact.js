document.addEventListener("DOMContentLoaded", (event) => {
  function map() {
    const marker_coords = [48.254614, -4.089905];
    const map = L.map("map", {
      center: marker_coords,
      zoom: 18,
      zoomControl: false,
      gestureHandling: true,
    });
    // Correct instantiation of the marker
    L.marker(marker_coords, { interactive: false }).addTo(map);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      minZoom: 3,
      maxZoom: 18,
    }).addTo(map);
  }

  map();
});
