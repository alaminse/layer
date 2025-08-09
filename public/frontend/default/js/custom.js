(function ($) {
  "use strict";

  $(".popup-youtube, .popup-vimeo").magnificPopup({
    // disableOn: 700,
    type: "iframe",
    mainClass: "mfp-fade",
    removalDelay: 160,
    preloader: false,
    fixedContentPos: false,
  });

  if ($(window).width() < 991) {
    // menu fixed js code
    $(window).scroll(function () {
      var window_top = $(window).scrollTop() + 1;
      if (window_top > 50) {
        $(".main_menu").addClass("menu_fixed animated fadeInDown");
      } else {
        $(".main_menu").removeClass("menu_fixed animated fadeInDown");
      }
    });
  } else {
    window.onscroll = function () {
      myFunction();
    };

    var sticky_menu = document.getElementById("sticky_menu");
    var sticky = sticky_menu.offsetTop;

    function myFunction() {
      if (window.pageYOffset >= sticky) {
        sticky_menu.classList.add("sticky");
      } else {
        sticky_menu.classList.remove("sticky");
      }
    }
  }

  // easying js
  $(".page-scroll").bind("click", function (event) {
    var $anchor = $(this);
    var headerH = "80";
    $("html, body")
      .stop()
      .animate(
        {
          scrollTop: $($anchor.attr("href")).offset().top - headerH + "px",
        },
        1500,
        "easeInOutExpo"
      );
    event.preventDefault();
  });

    $(document).on('click',function(event){

        // lisence toggler
        $(".License_toggler").on("click", function () {
            $(".lisence_hover_box").toggleClass("active");
        });

        $(document).click(function (event) {
            if (
                !$(event.target).closest(".License_toggler,.lisence_hover_box  ").length
            ) {
                $("body").find(".lisence_hover_box").removeClass("active");
            }
        });
    });


    $(document).on('click',function(event){
        // for shoping_cart_toggler
        $(".shoping_cart_toggler").on("click", function () {
            $(".shoping_cart_notifyWrapper").toggleClass("active");
        });

        if (
            !$(event.target).closest(
                ".shoping_cart_toggler ,.shoping_cart_notifyWrapper"
            ).length
        ) {
            $("body").find(".shoping_cart_notifyWrapper").removeClass("active");
        }

    });

  (function ($) {
    var cartButtons = $(".product_number_count").find("span");

    $(cartButtons).on("click", function (e) {
      e.preventDefault();
      var $this = $(this);
      var target = $this.parent().data("target");
      var target = $("#" + target);
      var current = parseFloat($(target).val());

      if ($this.hasClass("number_increment")) target.val(current + 1);
      else {
        current < 1 ? null : target.val(current - 1);
      }
    });
  })(jQuery);
})(jQuery);
