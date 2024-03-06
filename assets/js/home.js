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
        schedulesBtn.innerText = "+ Nos horaire";
      }
    });
  }

  about();
});
