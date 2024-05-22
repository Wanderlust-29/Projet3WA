const owl = $(".owl-carousel");
owl.owlCarousel({
  items: 3,
  loop: false,
  margin: 0,
  responsiveClass: true,
  responsive: {
    0: {
      items: 1,
      nav: false,
    },
    600: {
      items: 3,
      nav: false,
    },
    1000: {
      items: 5,
      nav: true,
      loop: false,
    },
  },
});
