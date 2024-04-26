jQuery(document).ready( function () {
    "use strict";

    // home blog slider
    $('.home-main-banner .slider').owlCarousel({
        loop:true,
        margin:0,
        items:1,
        dots:true,
        autoplay:true,
        autoplayTimeout:3000,
        autoplaySpeed: 1500,
        nav: false
    });

    // more article slider
    $('.product-slider').owlCarousel({
        loop:true,
        margin:0,
        items:4,
        dots:false,
        autoplay:true,
        autoplayTimeout:3000,
        autoplaySpeed: 1500,
        nav: false,
        responsive:{
            0:{
                items:2,
                margin:15
            },
            600:{
                items:2,
                margin:30
            },
            1000:{
                items:4,
                margin: 38
            }
        }
    });

    // brand slider
    $('.brand-slider').owlCarousel({
        loop:true,
        margin:0,
        items:6,
        dots:false,
        autoplay:true,
        autoplayTimeout:3000,
        autoplaySpeed: 1500,
        nav: false,
        responsive:{
            0:{
                items:2,
                margin:15
            },
            600:{
                items:3,
                margin:30
            },
            1000:{
                items:6,
                margin: 38
            }
        }
    });

    // product details
    $("#product-image-slider").owlCarousel({
        items: 1,
        loop: true,
        URLhashListener: true,
        startPosition: 'URLHash', 
        nav: false,
        dots: false,
        autoplayTimeout:3000,
        autoplaySpeed: 1500,
    });

    // quantity increase decrese
    const minus = $('.quantity__minus');
    const plus = $('.quantity__plus');
    // const input = $('.quantity__input');
    minus.click(function(e) {
        e.preventDefault();
        var input = $(this).next('.quantity__input');
        var value = input.val();
        if (value > 1) {
        value--;
        }
        input.val(value);
    });
    
    plus.click(function(e) {
        e.preventDefault();
        var input = $(this).prev('.quantity__input');
        var value = input.val();
        value++;
        input.val(value);
    });

    // price slider
    function formatSliderValues(value) {
        if (value == null) return 'Any';
        /* This code formats a number in a human value, by adding separators (forces 2 decimal). 
           Ex."12345.67" to "12,345.67"  */
        var formattedNumber = value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        return '$'+formattedNumber;
      }
      
      var values = [0, 100, 200, 500, 1000, 1500, null];
      
      $( "#slider-range" ).slider({
          range: true,
          max: values.length - 1,
          values: [values[0], values.length - 1],
          slide: function(event, ui) {
            var min = values[ui.values[0]];
            var max = values[ui.values[1]];
            $("[name=min]").val(min);
            $("[name=max]").val(max);
            $("#min").text(formatSliderValues(min));
            $("#max").text(formatSliderValues(max));
        }
      });
      
      /* show initial values */
      var min = values[$("#slider-range").slider("values", 0)];
      var max = values[$("#slider-range").slider("values", 1)];
      $("[name=min]").val(min);
      $("[name=max]").val(max);
      $("#min").text(formatSliderValues(min));
      $("#max").text(formatSliderValues(max));
      
    
});