$(document).ready(function(){
  var carousel = $('.carousel');
  carousel.carousel();

  $('.carousel-prev').click(function() {
      carousel.carousel('prev');
  });

  $('.carousel-next').click(function() {
      carousel.carousel('next');
  });

  carousel.on('click', '.carousel-control-next, .carousel-control-prev', function() {
      setTimeout(function() {
          var activeIndex = carousel.find('.carousel-item.active').index();
          carousel.find('.carousel-item').css({
              opacity: 0.7,
              filter: 'blur(3px)'
          });
          carousel.find('.carousel-item').eq(activeIndex).css({
              opacity: 1,
              filter: 'blur(0)'
          });
      }, 100);
  });
});
