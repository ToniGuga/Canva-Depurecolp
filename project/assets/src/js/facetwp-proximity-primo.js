/* ======== Proximity SG (No Google MAP API)======== */

$(document).on('click', '.sg-locate-me', function(e) {
    var $this = $(this);
    var $facet = $this.closest('.facetwp-facet');
    // var $input = $facet.find('.facetwp-location');
    var $lat = $facet.find('.facetwp-lat');
    var $lng = $facet.find('.facetwp-lng');

    // reset
    if ($this.hasClass('f-reset')) {
        $lat.val('');
        $lat.val('');
        // $input.val('');
        FWP.autoload();
        return;
    }

    // loading icon
    $this.addClass('f-loading');

    // HTML5 geolocation
    navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;

            $lat.val(lat);
            $lng.val(lng);

            if (lat) {
                $($this).text('Posizione rilevata');

				setTimeout(() => {
					$('.sg-locate-reset').fadeToggle('slow');
				}, 300);

                $($this).attr('disabled', 'disabled');
            }

            FWP.autoload();
            $this.removeClass('f-loading');


            FWP.hooks.doAction('facetwp/geolocation/success', {
                'facet': $facet,
                'position': position,
            });

        },
        function(error) {
            $this.removeClass('f-loading');

            FWP.hooks.doAction('facetwp/geolocation/error', {
                'facet': $facet,
                'error': error
            });
        });
});

$(document).on('keyup', '.facetwp-location', function(e) {
    var $facet = $(this).closest('.facetwp-facet');
    $facet.find('.locate-me').toggleClass('f-reset', ('' !== $(this).val()));

    if (38 === e.which || 40 === e.which || 13 === e.which) {
        var curr_index = parseInt($facet.find('.location-result.active').attr('data-index'));
        var max_index = parseInt($facet.find('.location-result:last').attr('data-index'));
    }

    if (38 === e.which) { // up
        var new_index = (0 < curr_index) ? (curr_index - 1) : max_index;
        $facet.find('.location-result.active').removeClass('active');
        $facet.find('.location-result[data-index=' + new_index + ']').addClass('active');
    } else if (40 === e.which) { // down
        var new_index = (curr_index < max_index) ? (curr_index + 1) : 0;
        $facet.find('.location-result.active').removeClass('active');
        $facet.find('.location-result[data-index=' + new_index + ']').addClass('active');
    } else if (13 === e.which) { // enter
        $facet.find('.location-result.active').trigger('click');
    }
});

$(document).on('click focusout', function(e) {
    var $el = $(e.target);
    var $wrap = $el.closest('.location-wrap');

    if ($wrap.length < 1 || $el.hasClass('f-reset')) {
        $('.location-results').addClass('facetwp-hidden');
    }
});

$(document).on('focusin', '.facetwp-location', function() {
    var $facet = $(this).closest('.facetwp-facet');
    if ('' != $(this).val()) {
        $facet.find('.location-results').removeClass('facetwp-hidden');
    }
});

$(document).on('change', '.facetwp-radius', function() {
    var $facet = $(this).closest('.facetwp-facet');
    if ('' !== $facet.find('.facetwp-location').val()) {
        FWP.autoload();
    }
});

$(document).on('input', '.facetwp-radius-slider', function(e) {
    var $facet = $(this).closest('.facetwp-facet');
    $facet.find('.facetwp-radius-dist').text(e.target.value);
});

FWP.hooks.addAction('facetwp/refresh/proximity_sg', function($this, facet_name) {
    var lat = $this.find('.facetwp-lat').val();
    var lng = $this.find('.facetwp-lng').val();
    var radius = $this.find('.facetwp-radius').val();
    // var location = encodeURIComponent($this.find('.facetwp-location').val());
    FWP.frozen_facets[facet_name] = 'hard';
    FWP.facets[facet_name] = ('' !== lat && 'undefined' !== typeof lat) ?
        // [lat, lng, radius, location] : [];
        [lat, lng, radius] : [];
});

FWP.hooks.addFilter('facetwp/selections/proximity_sg', function(label, params) {
    return FWP_JSON['proximity_sg']['clearText'];
});
