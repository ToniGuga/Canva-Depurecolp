/** declare transaltion functions */
const { __, _x, _n, _nx } = wp.i18n;

// __('__', 'my-domain');
// _x('_x', '_x_context', 'my-domain');
// _n('_n_single', '_n_plural', number, 'my-domain');
// _nx('_nx_single', '_nx_plural', number, '_nx_context', 'my-domain')


/* from http://www.quirksmode.org/js/cookies.html */
function setCookie(name, value, days) {
	var expires;

	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		expires = "; expires=" + date.toGMTString();
	} else {
		expires = "";
	}
	document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function getCookie(name) {
	var nameEQ = encodeURIComponent(name) + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) === ' ')
			c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) === 0)
			return decodeURIComponent(c.substring(nameEQ.length, c.length));
	}
	return null;
}

function delCookie(name) {
	createCookie(name, "", -1);
}

/**
 * Determine if an element is in the viewport
 * (c) 2017 Chris Ferdinandi, MIT License, https://gomakethings.com
 * @param  {Node}    elem The element
 * @return {Boolean}      Returns true if element is in the viewport
 */

function isInViewport(elem) {
	var distance = elem.getBoundingClientRect();
	return (
		distance.top >= 0 &&
		distance.bottom <= (window.innerHeight || document.documentElement.clientHeight)
	);
};


/**
 * funzioni per calcolare l'aspect ratio
 * @param {*} x
 * @param {*} y
 */
function gcd(x, y) {
	if (y == 0) { return x; }
	return gcd(y, x % y);
}

function viewPortRatio() {
	var ratioCalc = gcd($(window).width(), $(window).height());
	var ratio = ($(window).width() / ratioCalc) / ($(window).height() / ratioCalc);
	return ratio;
}

/**
 * @returns {DOM Lang}
 */
function getDomLang() {
	var lang = $('html')[0].lang;
	return lang;
}

/**
 * per i link o pulsanti che devono aggiornare la pagina
 */
function refreshPage() {
	window.location.reload();
}

/**
 *
 * toggleText for jquery
 */

jQuery.fn.extend({
	toggleText: function (a, b) {
		var that = this;
		if (that.text() != a && that.text() != b) {
			that.text(a);
		} else
			if (that.text() == a) {
				that.text(b);
			} else
				if (that.text() == b) {
					that.text(a);
				}
		return this;
	}
});


/**
 * scroll to top
 * from fn-ui-interactive-elements.php
 */
(function ($) {
	$(window).on('scroll', function () {
		var scroll = $(window).scrollTop();
		if (scroll <= 200) {
			$(".scroll-to-top").hide();
		}
		if (scroll >= 500) {
			$(".scroll-to-top").show();
		}
	});

	$(document).on('click', '.scroll-to-top', function () {
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});
})(jQuery);

/**
 * Used to scroll to anchor id
 *
 * @param {*} id
 */
function scrollToAnchor(id) {
	var aTag = $('#' + id);
	$('html,body').animate({ scrollTop: aTag.offset().top }, 'slow');
}

/**
 * Used to scroll to anchor id
 *
 * @param {*} element
 */
function scrollToClass(element, offset) {
	$('html,body').animate({ scrollTop: $('.' + element).offset().top - offset }, 'slow');
}

/**
 * Used to check if google analytics is loaded or not
 *
 * @returns
 */
function isGtagLoaded() {
	if (typeof gtag === 'function') {
		return true;
	} else {
		return false;
		//       setTimeout(check_ga, 500);
	}
}

/**
 * Used to get the value of an url param
 *
 * @author Toni Guga
 * @param {*} paramName
 * @returns
 */

function searchUrlParams(paramName) {
	let searchParams = new URLSearchParams(window.location.search);
	let param = searchParams.get(paramName);
	return param;
}



/**
 * Used to toggle class. To bes used as a wrapper.
 * <div class="js-toggle-class js-target-_phone-fixed js-class-open">
 * <div class="_phone-fixed-icon">Link</div>
 * </div>
 *
 */

(function ($) {

	$(document).on('click', '.js-toggle-class', function (event) {

		event.preventDefault();

		var thisClass = $(this).attr('class').split(' ');
		var targetClass = thisClass[1].replace('js-target-', '');
		var toggledClass = thisClass[2].replace('js-class-', '');

		$('.' + targetClass).toggleClass(toggledClass);

	});

})(jQuery);
