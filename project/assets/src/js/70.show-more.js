/**
 * show-more
 * from fn-ui-interactive-elements.php
 */
(function($) {

    $('.show-more').on('click', function() {
        var self = $(this).parent().find('.roller-up');
        self.toggleClass('roll-this-down');
        $(this).toggleClass('show-less');
        $(this).toggleText(__('Show more', 'canva'), __('Show less', 'canva'));
    });

    $(document).on("facetwp-loaded", function() {
        $('.show-more').on('click', function() {
            var self = $(this).parent().find('.roller-up');
            self.toggleClass('roll-this-down');
            $(this).toggleClass('show-less');
            $(this).toggleText(__('Show more', 'canva'), __('Show less', 'canva'));
        });

    });

    $(document).on("facetwp-refresh", function() {
        $('.show-more').on('click', function() {
            var self = $(this).parent().find('.roller-up');
            self.toggleClass('roll-this-down');
            $(this).toggleClass('show-less');
            $(this).toggleText(__('Show more', 'canva'), __('Show less', 'canva'));
        });
    });
})(jQuery);



/**
 * roller inner blocks
 * from fn-ui-interactive-elements.php
 */
(function($) {

    $(document).on('click', '.roller-toggler-click', function() {
        $('.roller-toggler').slideToggle('500');
    });

})(jQuery);

