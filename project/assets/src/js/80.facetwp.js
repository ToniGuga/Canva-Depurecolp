/**
 * FacetWP Filtri e cotrolli mobile canva
 */
(function ($) {

	// $(document).on('facetwp-loaded', function() {
	//     $('.loading').hide();
	// });

	$(window).on('facetwp-loaded facetwp-refresh', function () {

		$('.loading').hide();

		var scroll = $(window).scrollTop();
		var viewPortWidth = $(window).width();
		var viewPortHeight = $(window).height();
		// var results = $('#facet-results'); // Hap

		if (viewPortWidth < 640) {

			$('.facetwp-filters-show').show();
			$('.facetwp-filters-hide').hide();
			$('.facetwp-filters-container').hide();

			$(document).on('click', '.facetwp-filters-show', function () {
				$('.facetwp-filters-container').slideDown();
				$('.facetwp-filters-show').hide();
				$('.facetwp-filters-hide').show();
				$('.facetwp-filters-container').addClass('overflow-y h-100vh');
			});

			$(document).on('click', '.facetwp-filters-hide', function () {
				$('.facetwp-filters-container').slideUp();
				$('.facetwp-filters-hide').hide();
				$('.facetwp-filters-show').show();
				$('.facetwp-filters-container').removeClass('overflow-y h-100vh');
				// $('html,body').animate({ scrollTop: results.offset().top }, 'slow'); // Hap
				$('.loading').show();
				setTimeout(function () {
					$('.facetwp-filters-container').hide();
					$('.loading').hide();
				}, 350);
			});

		}
	});


	$(window).on('facetwp-loaded facetwp-refresh scroll', function () {

		var scroll = $(window).scrollTop();
		var viewPortWidth = $(window).width();
		var viewPortHeight = $(window).height();
		var mobileNavigationBarHeight = $(".mobile-navigation").outerHeight();
		var filtersPosition = $('.facetwp-filters').position();

		if (viewPortWidth < 640 && filtersPosition) {

			if (scroll > (filtersPosition.top - mobileNavigationBarHeight)) {
				$('.facetwp-filters').removeClass('sticky');
				$('.facetwp-filters').css({
					'position': 'fixed',
					'z-index': '10',
					'width': '100%',
					'top': mobileNavigationBarHeight + 'px',
					'left': '0',
					'padding': '.5rem 1rem',
					'border-bottom': '1px solid #b8b8b6',
				});

				$('.facetwp-filters-container').addClass('overflow-y h-100vh');

			} else {
				$('.facetwp-filters').removeAttr('style');
				$('.facetwp-filters-container').removeClass('overflow-y h-100vh');
			}

		} else {
			// metti sticky se i filtri in desktop stanno dentro il viewPortHeight
			if ($('.facetwp-filters').outerHeight < viewPortHeight) {
				$('.facetwp-filters').addClass('sticky');
			}

		}

	});

	/* invia il pageview a google analytics mentre si utilizzano i filtri */
	$(document).on('facetwp-loaded', function () {
		if (FWP.loaded) {
			ga('send', 'pageview', window.location.pathname + window.location.search);
		}
	});

	/* scrolla la pagina all'inizio dei risultati */
	$(document).on("facetwp-refresh", function () {
		if (FWP.loaded) {
			scrollToAnchor('facetwp-results');
		}
	});

	/* riattiva il b-lazy per il facetwp */
	$(document).on("facetwp-loaded", function () {
		if (FWP.loaded) {
			var bLazy = new Blazy();
			bLazy.revalidate();
		}
	});
})(jQuery);

