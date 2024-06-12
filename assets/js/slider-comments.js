document.addEventListener("DOMContentLoaded", function () {
  const owl = $(".owl-carousel-comments");
  owl.owlCarousel({
    items: 3,
    loop: false,
    margin: 10,
    dots: false,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
        nav: false,
      },
      600: {
        items: 2,
        nav: false,
      },
      900: {
        items: 3,
        nav: false,
      },
      1200: {
        items: 4,
        nav: true,
        loop: false,
      },
    },
  });
});
