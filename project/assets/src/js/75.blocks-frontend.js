(function ($) {

	/**
	 *
	 * script for hero-slider
	 *
	 */
	// var isSwipperLoaded = isSwipperLoaded();
	// console.log(isSwipperLoaded);

	try {
		var simpleHeroSlider = new Swiper("._hero_slider", {
			loop: true,
			autoplay: true,
			pauseOnMouseEnter: true,
			slidesPerView: "auto",
			centeredSlides: true,
			slideToClickedSlide: false,
			preloadImages: false,
			lazy: true,
			pagination: {
				el: '.swiper-pagination',
				type: 'bullets',
				clickable: 'true',
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			keyboard: {
				enabled: true,
			},

		});

		simpleHeroSlider.on('slideChange', function () {
			$('.swiper-slide').find('.video-bg').each(function () {
				if ($(this).is(':visible')) {
					this.pause();
					this.currentTime = 0;
					this.play();
				} else {
					this.currentTime = 0;
					this.pause();
				}
			});
		});
	}
	catch (e) {
		console.log("no swiper");
	}

	/**
	 * Accordion with Jquery
	 * from https://css-tricks.com/snippets/jquery/simple-jquery-accordion/
	 *
	 */

	var allPanels = $('.accordion > dd:not(.active)').hide();

	$('.accordion > dt > a').click(function () {
		$this = $(this);
		$next = $this.parent().next();
		$prev = $this.parent().prev();

		if (!$next.hasClass('active')) {
			allPanels.removeClass('active').slideUp();
			$next.addClass('active').slideDown();
			$prev.removeClass('active').slideUp();
		}

		return false;
	});


})(jQuery);
