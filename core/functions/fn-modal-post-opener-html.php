<?php
defined('ABSPATH') || exit;

?>

<div id="modal-post-opener" class="_modal-post-opener modal-out" style="display:none;">

	<a class="_modal-close-button cursor-pointer absolute top-4 right-4 h-12 w-12 p-1 rounded-full bg-primary transition-colors hover:bg-white group">
		<?php echo canva_get_svg_icon($name = 'fontawesome/light/times', $class = 'w-10 h-10 bg-gray-100 transition-colors group-hover:bg-white p-1 rounded-full'); ?>
	</a>


	<div class="_modal-loading">
		<?php echo canva_get_svg_icon('fontawesome/regular/spinner-third', 'w-16 animate-spin'); ?>
	</div>

	<div class="_modal-filter"></div>

	<div class="_modal-content scrolling-touch"></div>

	<div class="_modal-content-messages w-full md:w-1/2 hidden flex items-center">
		<?php _e('Grazie il tuo messaggio è stato inviato.', 'silmax'); ?>
	</div>

</div>
