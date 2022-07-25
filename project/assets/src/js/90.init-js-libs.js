/**
 * canva load b-lazy
 * from fn-register-styles.php
 *
 */
;
(function() {
    var bLazy = new Blazy({
        breakpoints: [{
                /* max-width */
                width: 640,
                src: 'data-src-small'
            },
            {
                /* max-width */
                width: 960,
                src: 'data-src-medium'
            },
        ]
    });
})();


/**
 *
 * sharetools copy to clipboard
 *
 */
var clipboard = new ClipboardJS('.copythistoshare');

clipboard.on('success', function(e) {
    alert("Link copiato");
    e.clearSelection();
});
