$(document).ready(function(){
 
      // const player = new Plyr('.player');

      const swiper = new Swiper('.swiper', {
        speed: 400,
        spaceBetween: 100,   
        autoplay: {
          delay: 5000,
        },
        parallax:true,
        pagination:{
          el: ".swiper-pagination",
          clickable: true,
        },
        breakpoints: {
          // when window width is >= 320px
          320: {
            slidesPerView: 2,
            spaceBetween: 20
          },
          // when window width is >= 480px
          480: {
            slidesPerView: 3,
            spaceBetween: 30
          },
          // when window width is >= 640px
          640: {
            slidesPerView: 4,
            spaceBetween: 40
          },
          // when window width is >= 640px
          991: {
            slidesPerView: 6,
            spaceBetween: 40
          }
        }
      });
});
