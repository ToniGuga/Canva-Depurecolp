/**
 *
 * canva_off_canvas_menu js
 * apre chiude il menu on canvas del sito
 * from f-site-menu.php
 *
 */

(function ($) {

	$(document).on('click', '.hamburger-modal', function (e) {
		var viewPortWidth = $(window).width();

		$(this).toggleClass('open');
		$("body").addClass("overflow-y-hide");

		if (viewPortWidth > 959) {
			$('.off-canvas-desktop').removeClass('hide');
		} else {
			$('.off-canvas-mobile').removeClass('hide');
			var mobileNavigationHeight = $('.mobile-navigation').outerHeight();
			// $('.main').css('padding-top', mobileNavigationHeight);
			$('.off-canvas-mobile').css('margin-top', mobileNavigationHeight);
		}
	});

	// close off canvas desktop & mobile by clicking hamburger button
	$(document).on('click', '.hamburger-modal.open', function (e) {
		var viewPortWidth = $(window).width();

		$(this).toggleClass('open');
		$("body").removeClass("overflow-y-hide");

		if (viewPortWidth > 959) {
			$('.off-canvas-desktop').addClass('fade-out');
			setTimeout(function () {
				$('.off-canvas-desktop').addClass('hide');
				$('body').removeClass('overflow-y-hide');
				$('.hamburger-modal').toggleClass('open');
				$('.off-canvas-desktop').removeClass('fade-out');
			}, 350);
		} else {
			$('.off-canvas-mobile').addClass('fade-out');
			setTimeout(function () {
				$('.off-canvas-mobile').addClass('hide');
				$('body').removeClass('overflow-y-hide');
				$('.hamburger-modal').toggleClass('open');
				$('.off-canvas-mobile').removeClass('fade-out');
			}, 350);
		}
	});

	// close off canvas desktop by clicking close button
	$(document).on('click', '.off-canvas-close', function () {
		$('.off-canvas-desktop').addClass('fade-out');
		setTimeout(function () {
			$('.off-canvas-desktop').addClass('hide');
			$('body').removeClass('overflow-y-hide');
			$('.hamburger-modal').toggleClass('open');
			$('.off-canvas-desktop').removeClass('fade-out');
		}, 350);
	});


	// close off canvas desktop & mobile by clicking hamburger button
	$(document).on('click', '.menu-item-has-children > a', function (e) {
		e.preventDefault();

		var viewPortWidth = $(window).width();

		if (viewPortWidth > 959) {
			// Do nothing
		} else {
			$(this).parent().find('.dropdown').slideToggle();
			$(this).parent().toggleClass('open');
		}

	});


	$(window).on('scroll resize', function () {

		var scroll = $(window).scrollTop();
		var viewPortHeight = $(window).height();

		if (scroll < 300) {
			$(".site-navigation-fixed").addClass("hide-inside");
			$(".site-navigation-fixed").addClass("invisible");
		}

		if (scroll > viewPortHeight) {
			$(".site-navigation-fixed").removeClass("invisible");
			$(".site-navigation-fixed").removeClass("hide-inside");
		}

	});

	$(window).on('resize', function () {

		var viewPortWidth = $(window).width();

		// close off canvas mobile when resizing view port width
		if (viewPortWidth > 959) {
			if ($('.hamburger-modal.open')[0]) {
				$('.off-canvas-mobile').addClass('fade-out');
				setTimeout(function () {
					$('.off-canvas-mobile').addClass('hide');
					$('body').removeClass('overflow-y-hide');
					$('.hamburger-modal').toggleClass('open');
					$('.off-canvas-mobile').removeClass('fade-out');
				}, 350);
			}
		} else {
			if ($('.hamburger-modal.open')[0]) {
				$('.off-canvas-mobile').addClass('fade-out');
				setTimeout(function () {
					$('.off-canvas-mobile').addClass('hide');
					$('body').removeClass('overflow-y-hide');
					$('.hamburger-modal').removeClass('open');
					$('.off-canvas-mobile').removeClass('fade-out');
				}, 350);
			}
		}

	});


	/**
	 * funzione che gestisce i sub menu del sito in versione desktop
	 */

	//mostra info mega menu della voce
	$('.desktop-navigation li.menu-item-has-children').on('mouseenter', function () {
		var hasMegaMenu = $(this).find('.dropdown').find('.mega-menu');

		if (hasMegaMenu > 0) {
			$(this).find('.dropdown').find('.mega-menu').remove();
		} else {
			$('ul.menu', this).removeClass('hide');
			$(this).toggleClass('exploded');
			var megaMenu = $(this).children('a').find('.data-for-mega-menu').children('.mega-menu').clone();
			$(this).find('.dropdown').append(megaMenu);
		}
	});

	// elimina info mega menu della voce
	$('.desktop-navigation li.menu-item-has-children').on('mouseleave', function () {
		$('ul.menu', this).addClass('hide');
		$(this).toggleClass('exploded').children('.dropdown').children('.mega-menu').remove();
	});

})(jQuery);
