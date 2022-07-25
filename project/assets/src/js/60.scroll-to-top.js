/**
 * scroll to top
 * from fn-ui-interactive-elements.php
 */
 (function($) {
    $(window).on('scroll', function() {
        var scroll = $(window).scrollTop();
        if (scroll <= 200) {
            $(".scroll-to-top").hide();
        }
        if (scroll >= 500) {
            $(".scroll-to-top").show();
        }
    });

    $(document).on('click', '.scroll-to-top', function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });
})(jQuery);

