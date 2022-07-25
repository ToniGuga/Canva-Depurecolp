/**
 * Traduzione wp captcha in base alla lingua del DOM
 */
(function($) {
    if (getDomLang() == 'en-US') {
        $('.c4wp-display-captcha-form label').text('Resolve Captcha *');
    } else if (getDomLang == 'fr-FR') {
        $('.c4wp-display-captcha-form label').text('Résoudre le captcha *');
    } else if (getDomLang == 'es-ES') {
        $('.c4wp-display-captcha-form label').text('Resolver Captcha *');
    } else if (getDomLang == 'de-DE') {
        $('.c4wp-display-captcha-form label').text('Captcha lösen *');
    }
})(jQuery);