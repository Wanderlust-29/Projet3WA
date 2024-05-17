document.addEventListener("DOMContentLoaded", function () {
  var splide = new Splide(".splide", {

    autoHeight : true,
    autoWidth: true,
    perPage     : 3,
    perMove     : 1,
    focus       : 'center',
    omitEnd  : true,
    pagination: false,
  });

  splide.mount();
});
