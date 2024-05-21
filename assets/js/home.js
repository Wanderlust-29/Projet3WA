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

  function about() {
    const coordinate = document.querySelector(".coordinates");
    const coordinateBtn = document.querySelector(".coordinates-btn");
    const schedules = document.querySelector(".schedules");
    const schedulesBtn = document.querySelector(".schedules-btn");
    const containerMap = document.querySelector(".container-map");
    containerMap.style.display = "none";
    coordinate.style.display = "none";
    schedules.style.display = "none";

    coordinateBtn.addEventListener("click", () => {
      if (
        coordinate.style.display === "none" ||
        coordinate.style.display === ""
      ) {
        coordinate.style.display = "block";
        coordinateBtn.innerText = "- Nos coordonnées";
        containerMap.style.display = "block";
      } else {
        coordinate.style.display = "none";
        coordinateBtn.innerText = "+ Nos coordonnées";
        containerMap.style.display = "none";
      }
    });
    schedulesBtn.addEventListener("click", () => {
      if (
        schedules.style.display === "none" ||
        schedules.style.display === ""
      ) {
        schedules.style.display = "block";
        schedulesBtn.innerText = "- Nos horaires";
      } else {
        schedules.style.display = "none";
        schedulesBtn.innerText = "+ Nos horaires";
      }
    });
  }

  about();
  map();
});
