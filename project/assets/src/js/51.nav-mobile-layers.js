(function($) {

    $('.off-canvas-mobile').removeClass('hide inset-0 fade-in');

    $(document).on('click', '.hamburger-modal', function() {

        $('.nav-layers-mobile-nav,.nav-layers-mobile,.nav-layers-mobile-subnav').remove();

        var navLayersMobile = '<div class="nav-layers-mobile"></div>';

        var navLayersMobileNav = '<div class="nav-layers-mobile-nav"><div class="nav-layers-mobile-nav-close"></div></div>';

        $(this).addClass('open');

        if ($('.nav-layers-mobile').length == 0) {

            $('.mobile-navigation').append(navLayersMobile);
            $('.off-canvas-mobile').prepend(navLayersMobileNav);
        }

        $('.mobile-navigation').find('.nav-layers-mobile').fadeIn();

        $('.off-canvas-mobile').toggleClass('show');

    });

    function navLayers(event) {

        event.preventDefault();

        var navLayersMobileTitle = $(this).children('a').html();
        var navLayersMobileItems = $(this).children('.dropdown').html();

        var navLayersMobileNav = '<div class="nav-layers-mobile-subnav"><div class="nav-layers-mobile-nav"><div class="nav-layers-mobile-nav-back"></div><div class="nav-layers-mobile-nav-title">' + navLayersMobileTitle + '</div><div class="nav-layers-mobile-nav-close"></div></div><div class="nav-layers-mobile-submenu"><ul class="nav-layers-mobile-sublist">' + navLayersMobileItems + '</ul></div></div>';

        $('footer').append(navLayersMobileNav);

        // animate doesn't do anything but it is needed to make the css animation work
        $('footer').children('.nav-layers-mobile-subnav').animate({}, 0, function() {
            $('footer').children('.nav-layers-mobile-subnav').addClass('show');
        });

    }

    $(document).on('click', '.off-canvas-mobile .menu .menu-item-has-children', navLayers);

    $(document).on('click', '.nav-layers-mobile-submenu .menu-item-has-children', navLayers);

    $(document).on('click', '.nav-layers-mobile-nav-back', function() {

        var subnav = $(this).closest('.nav-layers-mobile-subnav');

        $(subnav).removeClass('show');

        setTimeout(function() {
            $(subnav).remove();
        }, 500);

    });

    $(document).on('click', '.nav-layers-mobile, .nav-layers-mobile-nav-close', function() {

        // $.when(removeDummyMobile()).done(function() // when could be used to have more control on animation end
        $('.show').removeClass('show');
        $('.nav-layers-mobile').fadeOut();

        setTimeout(function() {
            $('.nav-layers-mobile,.nav-layers-mobile-subnav').remove();
            $('.hamburger-modal').removeClass('open');
        }, 500);

    });

})(jQuery);