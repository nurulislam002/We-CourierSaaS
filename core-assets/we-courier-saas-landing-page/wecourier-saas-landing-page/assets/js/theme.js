$(document).ready(function(){

    var options = {
        strings: [ 
            'order shippment',
            'package delivery',
            'parcel delivery',
            'courier management',
            'logistic supports'
            ],
        typeSpeed: 100,
        backSpeed: 50,
        loop:true
      };

      var typed = new Typed('.typer', options);


      const player = new Plyr('.player');

      const swiper = new Swiper('.swiper', {
        speed: 400,
        spaceBetween: 100,
        pagination:{
            clickable: true,
        }
      });
});
