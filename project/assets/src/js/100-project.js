
/**
 * 1) MEGA MENU Applications
 * 2) MEGA MENU Tools
 * 3) Gallery Slider Prodotto
 */
$(document).ready(function () {
	let ajaxUrl = WPURLS.ajaxurl;

	// 1) MEGA MENU applications
	$.ajax({
		url: WPURLS.ajaxurl + '?action=abac_ajax_application_mega_menu&term_slug=application&taxonomy=product_cat',
	})
		.done(function (content) {
			$('.nav-mega-menu-wrap-applications .mega-submenu').empty();
			$('.nav-mega-menu-wrap-applications .mega-submenu').append(content);
		})
		.fail(function (jqXHR, textStatus, errorThrown) {
			console.log('errore menu applications not loading');
		});

	// 2) MEGA MENU Tools
	$.ajax({
		url: WPURLS.ajaxurl + '?action=abac_ajax_tools_mega_menu&term_slug=tools&taxonomy=product_cat',
	})
		.done(function (content) {
			$('.nav-mega-menu-wrap-tools .mega-submenu').empty();
			$('.nav-mega-menu-wrap-tools .mega-submenu').append(content);
		})
		.fail(function (jqXHR, textStatus, errorThrown) {
			console.log('errore menu tools not loading');
		});


	// 3) Gallery Slider Prodotto
	if ($('body').hasClass('single-product')) {

		/* swiper gallery thumbs */
		var galleryThumbs = new Swiper('.gallery-thumbs', {
			spaceBetween: 16,
			slidesPerView: 4,
			freeMode: true,
			watchSlidesVisibility: true,
			watchSlidesProgress: true,
			// direction: 'vertical'
		});

		const swiperGalleryId = $('._product-gallery-content').children().attr('id');

		/* swiper gallery */
		var gallerySwipe = new Swiper('.' + swiperGalleryId, {
			preloadImages: false,
			lazy: false,
			grabCursor: true,
			autoplay: false,
			loop: true,
			centeredSlidesBounds: false,
			centeredSlides: false,
			centerInsufficientSlides: false,
			slidesOffsetBefore: false,
			slidesOffsetAfter: false,
			freeMode: false,
			speed: 300,
			slidesPerView: 1,
			spaceBetween: 0,
			pagination: {
				el: '.swiper-pagination',
				clickable: 'true',
				dynamicBullets: false,
				dynamicMainBullets: 5,
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			thumbs: {
				swiper: galleryThumbs
			}
		});


		// Load swiper lightbox gallery
		initPhotoSwipeFromDOM('.photoswipe-item');

	}

	// 4) gestione tabella _additional_attributes accordion mode
	let ableAdditionalAttributesTabbleHeight = $('._additional_attributes').outerHeight();

	if (ableAdditionalAttributesTabbleHeight > 300) {
		$('._additional_attributes').css('height', '200');
		$('._slide-down').fadeIn();
	}
});


/**
 * funzione per caricare il carrello ajax in modale
 */
function showModalCartAjax() {
	// let ajaxUrl = WPURLS.ajaxurl;
	// console.log(ajaxUrl);

	// $.ajax(ajaxUrl + '?action=eqipe_wooc_modal_cart')
	$.ajax({
		// url: ajaxUrl + '?action=eqipe_wooc_modal_cart',
		url: WPURLS.ajaxurl + '?action=eqipe_wooc_modal_cart',

		beforeSend: function (response) {
			$('body').addClass('overflow-y-hidden');
			$('._canva-loading-footer').addClass('w-screen h-screen').removeClass('hidden').animate({ opacity: 1 }, 350);
		},
		complete: function (response) {
			$('._canva-loading-footer').addClass('hidden').removeClass('w-screen h-screen').animate({ opacity: 0 }, 750);
		},
	})
		.done(function (content) {
			$('._wooc-modal-cart-container').empty();
			$('._wooc-modal-cart-container').append(content);
			// $('._wooc-modal-cart-container').css('min-height', min_height + 'px');

			$('._wooc-modal-cart').removeClass('-right-full').addClass('right-0');
		})
		.fail(function (jqXHR, textStatus, errorThrown) {
			// Azioni da eseguire in caso di errore chiamata. Definire con MT output html e css
			console.log('errore cart not loading');
		});
}


/**
 * mostra carello sul click voce/icona menu
 */
$(document).on('click', '.menu-item-icon-cart, .added_to_cart', function (event) {

	$cartItems = $(this).children().data('items');


	if ($cartItems > 0) {

		if ($('body').hasClass('woocommerce-cart') || $('body').hasClass('woocommerce-checkout')) {
			// do nothing
		} else {
			event.preventDefault();

			showModalCartAjax();
		}

	}

});


/**
 * mostra carrello aggiornato dopo la rimozione del prodotto
 */
$(document).ready(function () {

	let removeItem = searchUrlParams('removed_item');
	// console.log(removeItem);

	if (removeItem) {
		showModalCartAjax();
	}

});


/**
 * chiude carrello in modale
 */
$(document).on('click', '._close-wooc-modal-cart, ._wooc-modal-cart-left', function (event) {
	event.preventDefault();
	$('._wooc-modal-cart').removeClass('right-0').addClass('-right-full');
	$('body').removeClass('overflow-y-hidden');
});


/**
 * Ajax delete product in the cart
 */
$(document).on('click', '._cart-item a.remove', function (e) {
	e.preventDefault();

	let ajaxUrl = WPURLS.ajaxurl;

	$(this).parentsUntil('._cart-item').parent().fadeOut(150);

	setTimeout(() => {
		$(this).parentsUntil('._cart-item').parent().remove();
	}, 150);

	setTimeout(() => {
		$.ajax(ajaxUrl + '?action=canva_wooc_ajax_update_modal_cart_fragment')
			.done(function (content) {
				// $('._product-gallery-content').fadeOut();
				// $('._loading').fadeIn();

				$('._cart-sub-totals').animate({ opacity: 0 }, 150);
				setTimeout(() => {
					$('._cart-sub-totals').empty();
					$('._cart-sub-totals').append(content);
					$('._cart-sub-totals').animate({ opacity: 1 }, 150);
				}, 150);
			})
			.fail(function (jqXHR, textStatus, errorThrown) {
				// Azioni da eseguire in caso di errore chiamata. Definire con MT output html e css
				console.log('errore cart not loading');
			});
	}, 300);

});


// /**
//  * Gestione on click Viste grid archive products
//  */
// $(document).on('click', '._change-view-2', function (event) {
// 	// event.preventDefault();
// 	$('._archive-products-wrap').animate({ opacity: 0 }, 150);
// 	setTimeout(() => {
// 		$('._archive-products-wrap').removeClass('lg:grid-cols-4').addClass('lg:grid-cols-2');
// 		$('._hero').removeClass('md:col-span-2');
// 	}, 300);
// 	setTimeout(() => {
// 		$('._archive-products-wrap').animate({ opacity: 1 }, 150);
// 	}, 350);

// });


// /**
//  * Gestione on click Viste grid archive products
//  */
// $(document).on('click', '._change-view-4', function (event) {
// 	$('._archive-products-wrap').animate({ opacity: 0 }, 150);
// 	setTimeout(() => {
// 		$('._archive-products-wrap').removeClass('lg:grid-cols-2').addClass('lg:grid-cols-4');
// 		$('._hero').addClass('md:col-span-2');
// 	}, 300);
// 	setTimeout(() => {
// 		$('._archive-products-wrap').animate({ opacity: 1 }, 150);
// 	}, 350);
// 	// event.preventDefault();
// });


(function ($) {
	//Tools Mega Menu
	// $(document).on('click', '.mega-menu-tools > a', function (event) {	event.preventDefault();
	$(document).on('mouseenter', '.mega-menu-tools > a', function (event) {

		// nascondi applications
		$('.nav-mega-menu-wrap-applications').fadeOut();
		//mostra tools
		$('.nav-mega-menu-wrap-tools .mega-submenu').show();
		setTimeout(() => {
			$('.nav-mega-menu-wrap-tools').fadeIn();
		}, 150);

	});

	//Applications Mega Menu
	// $(document).on('click', '.mega-menu-applications > a', function (event) { event.preventDefault();
	$(document).on('mouseenter', '.mega-menu-applications > a', function (event) {

		// nascondi tools
		$('.nav-mega-menu-wrap-tools').fadeOut();
		// mostra applications
		$('.nav-mega-menu-wrap-applications .mega-submenu').show();
		setTimeout(() => {
			$('.nav-mega-menu-wrap-applications').fadeIn();
		}, 150);

	});

	/**
	 * funzione per chiudere il mega menu
	 */
	function closeMegaMenu() {
		$('.nav-mega-menu-wrap-applications').fadeOut(150);
		$('.nav-mega-menu-wrap-tools').fadeOut(150);
	}

	// chiude mega menu in hover al passaggio da una voce menu ad un altra
	$('li.menu-item:not(.mega-menu-tools), li.menu-item:not(.mega-menu-applications)').mouseenter(function () {
		closeMegaMenu();
	});

	// chiude mega menu in hover
	$(document).on('mouseleave', '.nav-mega-menu-wrap-applications, .nav-mega-menu-wrap-tools', closeMegaMenu);

	//Product Range In Page Menu
	$(document).ready(function () {
		if ($('body').hasClass('home')) {
			$.ajax({
				// url: ajaxUrl + '?action=eqipe_wooc_modal_cart',
				url: WPURLS.ajaxurl + '?action=abac_ajax_application_product_range_in_page_menu&taxonomy=product_cat',

				// beforeSend: function (response) {
				// $('.nav-mega-menu-wrap-tools').fadeOut();
				// },

				// complete: function (response) {
				// 	$('._canva-loading-footer').addClass('hidden').removeClass('w-screen h-screen').animate({ opacity: 0 }, 750);
				// },?action=abac_ajax_tools_mega_menu&term_slug=tools&taxonomy=product_cat
			})
				.done(function (content) {
					$('._prodcut-range-content-wrap').empty();
					$('._prodcut-range-content-wrap').append(content);
					// setTimeout(() => {
					// 	$('.nav-mega-menu-wrap-applications').fadeIn();
					// 	// $('.nav-mega-menu-wrap-applications .mega-menu').fadeIn();
					// }, 150);
				})
				.fail(function (jqXHR, textStatus, errorThrown) {
					// Azioni da eseguire in caso di errore chiamata. Definire con MT output html e css
					console.log('errore cart not loading');
				});
		}

	});

	//Applications In Page Menu
	$(document).ready(function () {
		if ($('body').hasClass('home')) {
			$.ajax({
				// url: ajaxUrl + '?action=eqipe_wooc_modal_cart',
				url: WPURLS.ajaxurl + '?action=abac_ajax_application_in_page_menu&term_slug=application&taxonomy=product_cat',

				// beforeSend: function (response) {
				// $('.nav-mega-menu-wrap-tools').fadeOut();
				// },

				// complete: function (response) {
				// 	$('._canva-loading-footer').addClass('hidden').removeClass('w-screen h-screen').animate({ opacity: 0 }, 750);
				// },?action=abac_ajax_tools_mega_menu&term_slug=tools&taxonomy=product_cat
			})
				.done(function (content) {
					$('._applications-content-wrap').empty();
					$('._applications-content-wrap').append(content);
					// setTimeout(() => {
					// 	$('.nav-mega-menu-wrap-applications').fadeIn();
					// 	// $('.nav-mega-menu-wrap-applications .mega-menu').fadeIn();
					// }, 150);
				})
				.fail(function (jqXHR, textStatus, errorThrown) {
					// Azioni da eseguire in caso di errore chiamata. Definire con MT output html e css
					console.log('errore cart not loading');
				});
		}
	});


})(jQuery);


/**
 * category header ajax via facetwp refresh
 */
(function ($) {
	document.addEventListener('facetwp-loaded', function () {

		if (FWP.facets.product_categories_mod_tools) {

			var taxonomy = $('body').data('tax');
			var termName = FWP.facets.product_categories_mod_tools[0];

			if (termName) {
				$.ajax(WPURLS.ajaxurl + '?action=abac_ajax_sub_term_header&term_slug=' + termName + '&taxonomy=' + taxonomy)
					.done(function (content) {

						$('._layer-status').addClass('clear-gray');
						$('._title').addClass('text-primary');
						$('._content-wrap').removeClass('isdark');
						$('._hero-primary-content ').removeClass('text-white');

						$('._sub-term').empty();
						$('._sub-term').append(content);

					})
					.fail(function (jqXHR, textStatus, errorThrown) {
						// Azioni da eseguire in caso di errore chiamata. Definire con MT output html e css
						console.log('errore cart not loading');
					});
			}
		}

		if (FWP.facets.product_categories_mod_kit_spare_parts) {

			var taxonomy = $('body').data('tax');
			var termName = FWP.facets.product_categories_mod_kit_spare_parts[0];

			console.log(termName);

			if (termName) {
				$.ajax(WPURLS.ajaxurl + '?action=abac_ajax_sub_term_header&term_slug=' + termName + '&taxonomy=' + taxonomy)
					.done(function (content) {

						$('._category-header').removeClass('bg-primary isdark').addClass('bg-gray-100');
						$('._title').addClass('text-primary');
						$('._content-wrap').removeClass('isdark');
						$('._hero-primary-content ').removeClass('text-white');

						$('._sub-term').empty();
						$('._sub-term').append(content);

					})
					.fail(function (jqXHR, textStatus, errorThrown) {
						// Azioni da eseguire in caso di errore chiamata. Definire con MT output html e css
						console.log('errore cart not loading');
					});
			}
		}

		if (FWP.facets.pumping_units) {

			var taxonomy = 'pumping_unit';
			var termName = FWP.facets.pumping_units[0];

			// console.log(termName);

			if (termName) {
				$.ajax(WPURLS.ajaxurl + '?action=abac_ajax_sub_term_header&term_slug=' + termName + '&taxonomy=' + taxonomy)
					.done(function (content) {

						$('._category-header').removeClass('bg-primary isdark').addClass('bg-gray-100');
						$('._title').addClass('text-primary');
						$('._content-wrap').removeClass('isdark');
						$('._hero-primary-content ').removeClass('text-white');

						$('._sub-term').empty();
						$('._sub-term').append(content);

					})
					.fail(function (jqXHR, textStatus, errorThrown) {
						// Azioni da eseguire in caso di errore chiamata. Definire con MT output html e css
						console.log('errore cart not loading');
					});
			}
		}

		if (FWP.facets.screw_hours) {

			var taxonomy = 'screw_hours';
			var termName = FWP.facets.screw_hours[0];

			// console.log(termName);

			if (termName) {
				$.ajax(WPURLS.ajaxurl + '?action=abac_ajax_sub_term_header&term_slug=' + termName + '&taxonomy=' + taxonomy)
					.done(function (content) {

						$('._category-header').removeClass('bg-primary isdark').addClass('bg-gray-100');
						$('._title').addClass('text-primary');
						$('._content-wrap').removeClass('isdark');
						$('._hero-primary-content ').removeClass('text-white');

						$('._sub-term').empty();
						$('._sub-term').append(content);

					})
					.fail(function (jqXHR, textStatus, errorThrown) {
						// Azioni da eseguire in caso di errore chiamata. Definire con MT output html e css
						console.log('errore cart not loading');
					});
			}
		}

	});
})(jQuery);


/** FacetWP adds tooltips to slider handles
 ** https://refreshless.com/nouislider/slider-options/#section-tooltips
 ** note that you need an array even if you want true for both handles
 **/
(function ($) {
	document.addEventListener('DOMContentLoaded', function () {
		if ('undefined' !== typeof FWP && 'undefined' !== typeof FWP.hooks) {
			if ('undefined' !== typeof FWP) {
				FWP.hooks.addFilter('facetwp/set_options/slider', function (opts, facet) {

					if (facet.facet_name == 'price_range') { // Change 'tank_capacity_l' to your slider facet's name

						var suffix = ' ' + FWP.settings[facet.facet_name]['suffix'];

						opts.tooltips = {
							to: function (value) {
								return value + suffix;
							},
							from: function (value) {
								return value + suffix;
							}
						};
					}

					if (facet.facet_name == 'tank_capacity_l') { // Change 'tank_capacity_l' to your slider facet's name

						var suffix = ' ' + FWP.settings[facet.facet_name]['suffix'];

						opts.tooltips = {
							to: function (value) {
								// return value + suffix;
								return nummy(value).format('0') + suffix;
							},
							from: function (value) {
								// return value + suffix;
								return nummy(value).format('0') + suffix;
							}
						};


						// Option 2:
						// Set DYNAMIC ranges, based on the slider's dynamic minimum and maximum values, which change when facets are interacted with.
						// This example calculates 3 pips in between min and max values.

						var min = FWP.settings['tank_capacity_l'].range.min;
						var max = FWP.settings['tank_capacity_l'].range.max;
						var half = (min + max) / 2;
						var quarter = (min + max) / 4;
						var threequarter = quarter * 3;

						var tank_capacity_l_range_dynamic = {
							'min': min,
							'25%': quarter,
							'50%': half,
							'75%': threequarter,
							'max': max
						};
						opts.range = tank_capacity_l_range_dynamic;

						// End Option 2

						// Set the pips options
						opts.pips = {
							mode: 'range',
							density: 8
						}
					}

					if (facet.facet_name == 'power_hp') { // Change 'power_hp' to your slider facet's name

						var suffix = ' ' + FWP.settings[facet.facet_name]['suffix'];

						opts.tooltips = {
							to: function (value) {
								// return value + suffix;
								return nummy(value).format('0.00') + suffix;
							},
							from: function (value) {
								// return value + suffix;
								return nummy(value).format('0.00') + suffix;
							}
						};

						// Option 2:
						// Set DYNAMIC ranges, based on the slider's dynamic minimum and maximum values, which change when facets are interacted with.
						// This example calculates 3 pips in between min and max values.

						var min = FWP.settings['power_hp'].range.min;
						var max = FWP.settings['power_hp'].range.max;
						var half = (min + max) / 2;
						var quarter = (min + max) / 4;
						var threequarter = quarter * 3;

						var power_hp_range_dynamic = {
							'min': min,
							'25%': quarter,
							'50%': half,
							'75%': threequarter,
							'max': max
						};
						opts.range = power_hp_range_dynamic;

						// End Option 2

						// Set the pips options
						opts.pips = {
							mode: 'range',
							density: 8
						}
					}

					if (facet.facet_name == 'air_flow_pa') { // Change 'air_flow_pa' to your slider facet's name

						var suffix = ' ' + FWP.settings[facet.facet_name]['suffix'];

						opts.tooltips = {
							to: function (value) {
								return nummy(value).format('0.00') + suffix;
							},
							from: function (value) {
								return nummy(value).format('0.00') + suffix;
							}
						};

						// console.log(opts);

						// Option 2:
						// Set DYNAMIC ranges, based on the slider's dynamic minimum and maximum values, which change when facets are interacted with.
						// This example calculates 3 pips in between min and max values.

						var min = FWP.settings['air_flow_pa'].range.min;
						var max = FWP.settings['air_flow_pa'].range.max;
						var half = (min + max) / 2;
						var quarter = (min + max) / 4;
						var threequarter = quarter * 3;

						var air_flow_pa_range_dynamic = {
							'min': min,
							'25%': quarter,
							'50%': half,
							'75%': threequarter,
							'max': max
						};
						opts.range = air_flow_pa_range_dynamic;

						// End Option 2

						// Set the pips options
						opts.pips = {
							mode: 'range',
							density: 8
						}
					}

					if (facet.facet_name == 'price_range') { // Change 'price_range' to your slider facet's name

						var suffix = ' ' + FWP.settings[facet.facet_name]['suffix'];

						opts.tooltips = {
							to: function (value) {
								return nummy(value).format('0,000.00') + suffix;
							},
							from: function (value) {
								return nummy(value).format('0,000.00') + suffix;
							}
						};

						// console.log(opts);

						// Option 2:
						// Set DYNAMIC ranges, based on the slider's dynamic minimum and maximum values, which change when facets are interacted with.
						// This example calculates 3 pips in between min and max values.

						var min = FWP.settings['price_range'].range.min;
						var max = FWP.settings['price_range'].range.max;
						var half = (min + max) / 2;
						var quarter = (min + max) / 4;
						var threequarter = quarter * 3;

						var price_range_range_dynamic = {
							'min': min,
							'25%': quarter,
							'50%': half,
							'75%': threequarter,
							'max': max
						};
						opts.range = price_range_range_dynamic;

						// End Option 2

						// Set the pips options
						opts.pips = {
							mode: 'range',
							density: 8
						}
					}

					return opts;
				});
			}
		}
	});
})(jQuery);


/**
 * Facetwp gestione Flyout mobile filters
 */
(function ($) {
	$(function () {
		if ('object' != typeof FWP) return;

		/* Choose which facets to display in the flyout, and/or change the facet display order */
		FWP.hooks.addFilter('facetwp/flyout/facets', function (facets) {

			let term = $('body').data('term');

			// console.log(facets);

			if (term === 'air-compressor') {
				return ["product_categories_air_compressors", "tank_capacity_l", "power_hp", "air_flow_pa", "price_range", "sort_by", "reset"];
			}

			if (term === 'air-treatment') {
				return ["product_categories_mod_air_treatment", "price_range", "sort_by", "reset"];
			}

			if (term === 'kit-spare-parts') {
				return ["product_categories_mod_kit_spare_parts", "pumping_units", "screw_hours", "price_range", "sort_by", "part_number_search", "reset"];
			}

			if (term === 'tools') {
				return ["product_categories_mod_tools", "price_range", "sort_by", "reset"];
			}

			if (term === 'application') {
				return ["product_categories_mod_application", "price_range", "sort_by", "reset"];
			}

		});

		/* Modify each facet's wrapper HTML */
		FWP.hooks.addFilter('facetwp/flyout/facet_html', function (facet_html) {
			// console.log(facet_html);
			return facet_html.replace('<h3>{label}</h3>', '<span class="_facetwp-filter-label h4 block my-8 mb-12">{label}</span>');
		});

		/* Modify the flyout wrapper HTML */
		FWP.hooks.addFilter('facetwp/flyout/flyout_html', function (flyout_html) {
			return flyout_html.replace('<div class="facetwp-flyout-close">x</div>', '<div class="facetwp-flyout-close flex justify-end"><a class="cursor-pointer"><svg svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class= "_icon times w-6 h-6"> <path d="M207.6 256l107.72-107.72c6.23-6.23 6.23-16.34 0-22.58l-25.03-25.03c-6.23-6.23-16.34-6.23-22.58 0L160 208.4 52.28 100.68c-6.23-6.23-16.34-6.23-22.58 0L4.68 125.7c-6.23 6.23-6.23 16.34 0 22.58L112.4 256 4.68 363.72c-6.23 6.23-6.23 16.34 0 22.58l25.03 25.03c6.23 6.23 16.34 6.23 22.58 0L160 303.6l107.72 107.72c6.23 6.23 16.34 6.23 22.58 0l25.03-25.03c6.23-6.23 6.23-16.34 0-22.58L207.6 256z"></path></svg></a></div>');
		});

		/* Flyout opened */
		FWP.hooks.addAction('facetwp/flyout/open', function () {
			$('body').addClass('overflow-y-hidden');
		});

		/* Flyout closed */
		FWP.hooks.addAction('facetwp/flyout/close', function () {
			$('body').removeClass('overflow-y-hidden');
		});

	});
})(jQuery);

/**
 * expand table product data
 */
(function ($) {
	$(document).on('click', '._slide-down', function (event) {
		$('._additional_attributes').animate({ height: '100%' }, 350);
		$(this).hide();
	});
})(jQuery);


