document.addEventListener("DOMContentLoaded", function () {
  $(".owl-carousel").owlCarousel({
    loop: true,
    center: true,
    margin: 0,
    autoHeight: false,
    responsiveClass: true,
    navigation: true,
    navigationText: [
      '<span class="fa-stack"><i class="fa fa-circle fa-stack-1x"></i><i class="fa fa-chevron-circle-left fa-stack-1x fa-inverse"></i></span>',
      '<span class="fa-stack"><i class="fa fa-circle fa-stack-1x"></i><i class="fa fa-chevron-circle-right fa-stack-1x fa-inverse"></i></span>',
    ],
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
        items: 4,
        nav: true,
        loop: false,
      },
      1200: {
        items: 5,
        nav: true,
        loop: false,
      },
    },
  });
});
