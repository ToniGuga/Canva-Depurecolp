/**
 *
 * apre e chiude modale ricerca generica sito
 * canva modal-search-menu
 * from fn-search.php
 *
 */

(function ($) {

	function modalOpen(event) {
		event.preventDefault();

		var modalContentClass = $(this).attr('data-modal-content');
		var modalContent = $('.' + modalContentClass).clone();

		console.log(modalContentClass);
		console.log(modalContent);

		$(document).find('._modal-container ._modal-content-append').append(modalContent);
		$('._modal-container ._modal-content-append .' + modalContentClass).removeClass('hidden');

		$("._modal-container").removeClass("hidden");
		$("._modal-container").removeClass("fade-out");
		$("._modal-container").addClass("flex");
		$("body").addClass("overflow-y-hidden");

		setTimeout(() => {
			var bLazy = new Blazy();
			bLazy.revalidate();

			document.querySelectorAll(".wpcf7 > form").forEach((
				function (e) {
					return wpcf7.init(e);
				}
			));
		}, 900);

		setTimeout(function () {
			document.addEventListener('wpcf7mailsent', function (event) {
				// Prende id dei moduli cf7 e controlla se sono stati inviati
				$.each(canvaCf7Ids, function (index, value) {
					if (value == event.detail.contactFormId) {
						// alert("Messaggio inviato!");
						$('.__modal-content-append').addClass("fade-out");

						setTimeout(function () {
							$('.__modal-content-append').addClass("hidden");
						}, 600);
						setTimeout(function () {
							$('._modal-content-msg').fadeToggle('slow');
						}, 1200);

						setTimeout(function () {
							$('._modal-content-msg').fadeToggle('slow');
						}, 2400);

						setTimeout(function () {
							modalClose(jQuery);
						}, 2800);
					}
				});

			}, false);
		}, 1200);

		// remove duplicated ajax-loader in modals
		$("._modal-container").find(".ajax-loader:not(:first)").remove();
	}

	function modalClose(jQuery) {
		$("._modal-container, .off-canvas-desktop, .off-canvas-mobile").addClass("fade-out");
		setTimeout(function () {
			$("._modal-container, .off-canvas-desktop, .off-canvas-mobile").addClass("hidden");
			$("._modal-container, .off-canvas-desktop, .off-canvas-mobile").removeClass("fade-out");
			$("body").removeClass("overflow-y-hidden");
			modalDestroy();
			$('.hamburger-modal').toggleClass('open');
		}, 750);
	}

	function modalDestroy(jQuery) {
		// $(document).find('._modal-container .__modal-content-append').children().remove();
		$('._modal-container .__modal-content-append').children().remove();
		$('.__modal-content-append').removeClass("hidden");
		$('.__modal-content-append').removeClass("fade-out");
	}

	// apre modale quando viene cliccato il pulsante o il link con la classe modal-open
	$(document).on('click', '.modal-open', modalOpen);

	//chiude la modale e menu quando viene cliccato la x
	$(document).on('click', '.modal-close', modalClose);

	//chiude la modale e menu quando viene premuto il tasto esc
	$(document).on('keyup', 'body', function (event) {
		if (event.which === 27) {
			modalClose();
		}
	});

})(jQuery);

/**
 * ajax modal post opener
 * ui html in fn-ui-interactive-elements.php
 *
 */

// Hap start
/* Ci sono due versioni.

La prima gestisce la modale anche sei prima del
breakpoint verticale (240px) in modo che appaia dopo l'header.
Però ha un bug sullo scrolldown.

La seconda (commentata), copre l'header se sei prima dei 240px di scroll.
Nella seconda bisogna aggiungere il behavior per il mobile (viewport e resize).

*/
(function ($) {

	// $(window).on('scroll resize', function () {

	// 	var scroll = $(window).scrollTop();
	// 	var view_port_width = $(window).width();
	// 	var header_height = 0;

	// 	// $('.modal').css('z-index','49');

	// 	// modificare il template ed eliminare la riga successiva
	// 	$('._modal-close-button.times.fixed').removeClass('fixed').addClass('absolute');

	// 	// modificare il css ed eliminare la riga successiva
	// 	// $('#modal-post-opener').css('transition','.2s all linear');

	// 	if (view_port_width < 960) { // Mobile

	// 		$('#modal-post-opener').removeClass('absolute').addClass('fixed');
	// 		header_height = $('.mobile-navigation').outerHeight();
	// 		$('#modal-post-opener').css('height', 'calc(100% - ' + header_height + 'px)');

	// 	} else { // Desktop

	// 		if (scroll < 240) { // Main nav (Stesso breakpoint del menu fisso)

	// 			$('#modal-post-opener').removeClass('fixed').addClass('absolute');

	// 			if ($('#alert-bar-above-menu').length && $('#alert-bar-above-menu').is(':visible')) {

	// 				banner_height = $('#alert-bar-above-menu').outerHeight();
	// 				partial_header_height = $('header').outerHeight();
	// 				header_height = banner_height + partial_header_height;

	// 			} else {

	// 				header_height = $('header').outerHeight();

	// 			}

	// 			$('#modal-post-opener').css('height', '100%');

	// 		} else { // Fixed nav

	// 			$('#modal-post-opener').removeClass('absolute').addClass('fixed');

	// 			header_height = $('.site-navigation-fixed').outerHeight();
	// 			$('#modal-post-opener').css('height', 'calc(100% - ' + header_height + 'px)');

	// 		}

	// 	}

	// 	$('#modal-post-opener').css('top', header_height + 'px');

	// });

	$(document).on('click', '.modal-post-open', function (event) {

		event.preventDefault();

		var ajaxUrl = WPURLS.ajaxurl;
		var id = $(this).attr('data-post-id');
		var actionName = $(this).attr('data-action-name');
		var templateName = $(this).attr('data-template-name');
		var nonce = $(this).attr('data-nonce');
		var animationIn = $(this).attr('data-animation-in');
		var animationOut = $(this).attr('data-animation-out');
		var containerClass = $(this).attr('data-modal-container-class');
		var modalIn = 'modal-in';
		var modalOut = 'modal-out';

		if ($(this).hasClass('modal-round-expansion')) {

			$(this).addClass('active');
			$(this).find('.text-wrapper, svg').hide();

			$('#modal-post-opener').addClass('modal-round-opener');

		}

		$.ajax(ajaxUrl + '?action=' + actionName + '&id=' + id + '&template=' + templateName + '&nonce=' + nonce)
			.done(function (content) {

				$('body').addClass('overflow-y-hidden relative');
				$('#modal-post-opener').show();

				setTimeout(() => {
					$('#modal-post-opener').find('._modal-content').append(content);
				}, 600);

				if (!animationIn) {
					$('#modal-post-opener').addClass('modal-in-from-bottom');
				} else {
					$('#modal-post-opener').addClass(animationIn);
				}

				$('#modal-post-opener').addClass(modalIn);
				$('#modal-post-opener').removeClass(modalOut);

				if (containerClass) {
					$('#modal-post-opener').find('._modal-content').addClass(containerClass);
				}

				setTimeout(() => {
					var bLazy = new Blazy();
					bLazy.revalidate();

					document.querySelectorAll(".wpcf7 > form").forEach((
						function (e) {
							return wpcf7.init(e);
						}
					));
				}, 2000);

				setTimeout(function () {
					document.addEventListener('wpcf7mailsent', function (event) {
						$.each(canvaCf7Ids, function (index, value) {
							if (value == event.detail.contactFormId) {
								$('._modal-content').addClass("fade-out");

								setTimeout(function () {
									$('._modal-content').addClass("hidden");
								}, 600);
								setTimeout(function () {
									$('._modal-content-messages').fadeToggle('slow');
								}, 1200);

								setTimeout(function () {
									$('._modal-content-messages').fadeToggle('slow');
								}, 2400);

								setTimeout(function () {
									modalClose(jQuery);
								}, 2800);
							}
						});
					}, false);
				}, 1200);

			});

	});

	$(document).on('click', '.inline-modal-post-open', function (event) {
		event.preventDefault();

		var animationIn = $(this).attr('data-animation-in');
		var animationOut = $(this).attr('data-animation-out');
		var containerClass = $(this).attr('data-modal-container-class');
		var modalIn = 'modal-in';
		var modalOut = 'modal-out';
		var inlineModalContent = $(this).attr('data-post-id');
		var modalContent = $('._modal-id-' + inlineModalContent).children().clone();

		if ($('.modal-post-open').hasClass('modal-round-expansion')) {

			$('.modal-post-open').removeClass('active');
			$('#modal-post-opener').removeClass('modal-round-opener');

			setTimeout(function () {

				$('.modal-post-open .text-wrapper, .modal-post-open svg, .modal-post-open img').fadeIn();

			}, 1000);

		}

		$('body').addClass('overflow-y-hidden relative');
		$('#modal-post-opener').show();
		setTimeout(() => {
			$('#modal-post-opener').find('._modal-content').append(modalContent);
		}, 600);

		if (!animationIn) {
			$('#modal-post-opener').addClass('modal-in-from-bottom');
		} else {
			$('#modal-post-opener').addClass(animationIn);
		}

		$('#modal-post-opener').addClass(modalIn);
		$('#modal-post-opener').removeClass(modalOut);

		if (containerClass) {
			$('#modal-post-opener').find('._modal-content').addClass(containerClass);
		}

		setTimeout(() => {
			var bLazy = new Blazy();
			bLazy.revalidate();

			document.querySelectorAll(".wpcf7 > form").forEach((
				function (e) {
					return wpcf7.init(e);
				}
			));
		}, 2000);

		setTimeout(function () {
			document.addEventListener('wpcf7mailsent', function (event) {
				$.each(canvaCf7Ids, function (index, value) {
					if (value == event.detail.contactFormId) {
						$('._modal-content').addClass("fade-out");

						setTimeout(function () {
							$('._modal-content').addClass("hidden");
						}, 600);

						setTimeout(function () {
							$('._modal-content-messages').fadeToggle('slow');
						}, 1200);

						setTimeout(function () {
							$('._modal-content-messages').fadeToggle('slow');
						}, 2400);

						setTimeout(function () {
							modalClose(jQuery);
						}, 2800);
					}
				});
			}, false);
		}, 1200);

	});

	$(document).on('click', '._modal-close-button, ._modal-filter', function () {

		var animationIn = $(this).attr('data-animation-in');
		var animationOut = $(this).attr('data-animation-out');
		var containerClass = $(this).attr('data-modal-container-class');
		var modalIn = 'modal-in';
		var modalOut = 'modal-out';

		if ($('.modal-post-open').hasClass('modal-round-expansion')) {

			$('.modal-post-open').removeClass('active');
			$('#modal-post-opener').removeClass('modal-round-opener');

		}

		setTimeout(() => {
			$('.modal-post-open .text-wrapper, .modal-post-open svg, .modal-post-open img').fadeIn();
		}, 600);

		$('body').removeClass('overflow-y-hidden relative');

		if (!animationOut) {
			$('#modal-post-opener').addClass('modal-out-to-bottom');
		} else {
			$('#modal-post-opener').addClass(animationOut);
		}

		$('#modal-post-opener').find('._modal-content').empty();

		setTimeout(function () {

			if (!animationIn) {
				$('#modal-post-opener').removeClass('modal-in-from-bottom');
				$('#modal-post-opener').addClass(modalOut);
			} else {
				$('#modal-post-opener').removeClass(animationIn);
				$('#modal-post-opener').addClass(modalOut);
			}

		}, 500);

		setTimeout(function () {

			if (!animationOut) {
				$('#modal-post-opener').removeClass('modal-out-to-bottom');
				$('#modal-post-opener').removeClass(modalIn);
			} else {
				$('#modal-post-opener').removeClass(animationOut);
				$('#modal-post-opener').removeClass(modalIn);
			}

			$('#modal-post-opener').hide();
			$('#modal-post-opener').find('._modal-content').removeClass(containerClass);

		}, 700);

	});

	$(document).on('keyup', 'body', function (e) {
		var animationIn = $('._modal-close-button').attr('data-animation-in');
		var animationOut = $('._modal-close-button').attr('data-animation-out');
		var containerClass = $('._modal-close-button').attr('data-modal-container-class');
		var modalIn = 'modal-in';
		var modalOut = 'modal-out';

		if (e.which === 27) {

			$('html').removeClass('overflow-y-hidden');
			$('body').removeClass('overflow-y-hidden relative');
			$('#modal-post-opener').addClass('modal-out-to-bottom');
			$('#modal-post-opener').find('._modal-content').empty();

			if ($('.modal-post-open').hasClass('modal-round-expansion')) {

				$('.modal-post-open').removeClass('active');
				$('#modal-post-opener').removeClass('modal-round-opener');

			}

			setTimeout(() => {
				$('.modal-post-open .text-wrapper, .modal-post-open svg, .modal-post-open img').fadeIn();
			}, 600);

			setTimeout(function () {

				if (!animationIn) {
					$('#modal-post-opener').removeClass('modal-in-from-bottom');
					$('#modal-post-opener').addClass(modalOut);
				} else {
					$('#modal-post-opener').removeClass(animationIn);
					$('#modal-post-opener').addClass(modalOut);
				}

			}, 500);

			setTimeout(function () {

				if (!animationOut) {
					$('#modal-post-opener').removeClass('modal-out-to-bottom');
					$('#modal-post-opener').removeClass(modalIn);
				} else {
					$('#modal-post-opener').removeClass(animationOut);
					$('#modal-post-opener').removeClass(modalIn);
				}

				$('#modal-post-opener').hide();
				$('#modal-post-opener').find('._modal-content').removeClass(containerClass);

			}, 700);

			// chiudi round modal
			$('.round-modal-wrap').fadeOut();
			$('.round-modal-open').removeClass('active');

			setTimeout(function () {
				$('.round-modal-open').children('span').show();
			}, 2000);


		}
	});

	// round modal
	$(document).on('click', '.round-modal-open', function () {

		$(this).addClass('active');
		$(this).children('span').hide();

		setTimeout(function () {
			$('.round-modal-wrap').fadeIn();
		}, 1000);

	});

	$(document).on('click', '.round-modal-close', function () {

		$('.round-modal-wrap').fadeOut();
		$('.round-modal-open').removeClass('active');

		setTimeout(function () {
			$('.round-modal-open').children('span').show();
		}, 2000);

	});


	// Apre modale di ricerca dal menu
	// $(document).on('click', '.menu-item-icon-search', function () {
	// 	$('._modal-search').fadeIn();
	// });

	// // Chiude modale di ricerca dal menu
	// $(document).on('click', '._modal-search-close', function () {
	// 	$('._modal-search').fadeOut();
	// });



	// tooltip
	(function ($) {
		$(document).on('click', '.tooltip', function () {
			$('.tooltiptext').toggleClass('visibility');
		});
	})(jQuery);

})(jQuery);
