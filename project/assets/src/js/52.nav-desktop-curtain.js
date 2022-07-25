(function($) {

    $(document).on('click', '.desktop-navigation .menu > li.menu-item-has-children', function(event) {

        event.preventDefault();

        var navHeight = $('.desktop-navigation').outerHeight() + 'px';
        var navDesktopCurtainLayer = '<div class="menu-desktop-curtain-overlay" style="top: ' + navHeight + '"></div>';
        var navDesktopCurtainNav = '<div class="menu-desktop-curtain-wrap"><ul class="menu-desktop-curtain" style="top: ' + navHeight + ';"></ul></div>';
        var navDesktopCurtainMenuItems = $(this).find('.dropdown').html();

        $('.desktop-navigation .menu > li.menu-item-has-children').removeClass('exploded');
        $(this).addClass('exploded');

        if ($('.menu-desktop-curtain-wrap').length) {

            $('.menu-desktop-curtain-wrap').empty().append(navDesktopCurtainMenuItems);

        } else {

            $('.desktop-navigation').append(navDesktopCurtainLayer).append(navDesktopCurtainNav);
            $('.menu-desktop-curtain-wrap').append(navDesktopCurtainMenuItems).hide();
            $('.desktop-navigation').find('.menu-desktop-curtain-wrap').slideDown('fast');

        }

    });

    $(document).on('click', '.menu-desktop-curtain-wrap li.menu-item-has-children', function() {

        $('.menu-desktop-curtain-wrap li.menu-item-has-children ul').removeClass('flex');
        $('.menu-desktop-curtain-wrap li.menu-item-has-children').removeClass('sub-exploded');
        $(this).addClass('sub-exploded');
        $(this).find('ul').addClass('flex');

    });

    $(document).on('click', '.menu-desktop-curtain-overlay, .desktop-navigation .menu > li:not(.menu-item-has-children)', function() {

        $('.menu-desktop-curtain-overlay,.menu-desktop-curtain-wrap').remove();
        $('.desktop-navigation .menu > li.menu-item-has-children').removeClass('exploded');

    });

})(jQuery);
