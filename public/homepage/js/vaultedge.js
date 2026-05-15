(function ($) {
    'use strict';

    var $window = $(window);

    // Sticky Header
    $window.on('scroll', function () {
        if ($window.scrollTop() > 100) {
            $('#ve-sticky').addClass('scrolled');
        } else {
            $('#ve-sticky').removeClass('scrolled');
        }
    });

    // Mobile Menu Toggle
    $('#ve-toggle').on('click', function () {
        $(this).toggleClass('active');
        $('#ve-mobile-menu').toggleClass('active');
    });

    // Close menu when clicking a link
    $('#ve-mobile-menu a').on('click', function () {
        $('#ve-toggle').removeClass('active');
        $('#ve-mobile-menu').removeClass('active');
    });

    // WOW Animation
    if ($.fn.init) {
        new WOW().init();
    }

    // Counter Up
    if ($.fn.counterUp) {
        $('.counter').counterUp({
            delay: 10,
            time: 2000
        });
    }

})(jQuery);
