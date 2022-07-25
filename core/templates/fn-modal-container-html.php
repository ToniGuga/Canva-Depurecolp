<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
// non modificare mai le seguenti classi perchè servono per far funzionare l'interattività sviluppata con jquery
// modal-container (serve a jquery per aprire e chiudere la modale dopo il click)
// modal-content-append (serve a jquery per inserire il contenuto della modale)

//esempio del codice html per aprire la modale contiene anche il contenuto
/**
 * <!-- Pulsante o Link per aprire la Modale -->
 * <button class="modal-open cursor-pointer" data-modal-content="promo-modal-content"><strong><a>Apri modale.</a></strong></button>
 * <!-- Pulsante o Link per aprire la Modale -->
 *
 * <!-- Contenuto della Modale -->
 * <div class="promo-modal-content hidden">
 * Contenuto html da mostrare nella modale
 * </div>
 * <!-- Contenuto della Modale -->
 *
 * Spiegazione!!!
 *
 * Per funzionare il valore del data attribute data-modal-content="" deve essere identico alla classe
 * del div nascosto con la classe hide. E possibile insere più modali nella stessa pagina cambiando per
 * ogni modale il valore e la classe spiegata prima.
 *
 *
 *
 */
?>

<div class="_modal-container hidden fixed justify-center inset-0 bg-white bg-opacity-95 z-50 fade-in w-full h-full overflow-y-auto p-8 md:p-16 ">

		<a class="modal-close cursor-pointer absolute top-0 right-0 p-4">
			<?php echo canva_get_svg_icon($name = 'fontawesome/regular/times', $class = 'w-5 h-5'); ?>
		</a>

		<div class="_modal-content-append w-full md:w-1/2">
			<?php // Jquery appends here the modal content ?>
		</div>

		<div class="_modal-content-msg w-full md:w-1/2 hidden flex items-center">
			<?php _e('Grazie il tuo messaggio è stato inviato.', 'silmax'); ?>
		</div>

</div>
