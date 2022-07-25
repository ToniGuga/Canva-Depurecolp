<?php
function is_url_from($url, $provider = 'youtube')
{
	if (strpos($url, $provider) > 0) {
		return true;
	}
}

function canva_get_google_map_url($address = '')
{
	return 'http://www.google.com/maps/preview#!q=' . urlencode($address);
}

add_action('genesis_entry_content', 'installazioni');
function installazioni()
{
?>
	</div>
	<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script> -->

	<section id="installazioni">

		<?php if (have_rows('elenco_installazioni')) : ?>
			<div style="overflow-x:scroll;">
				<table style="min-width:900px;">

					<!-- <thead>
					<tr>
						<th colspan="2">
							<input type="text" class="search" placeholder="Cerca" />
						</th>
					</tr>
				</thead> -->

					<?php while (have_rows('elenco_installazioni')) : the_row(); ?>

						<tr>
							<td class="nome" colspan="3">
								<?php the_sub_field('nome_commeciale'); ?>
							</td>

							<td class="indirizzo" colspan="4">
								<?php
								$indirizzo = [];
								if (get_sub_field('indirizzo')) {
									$indirizzo[] = get_sub_field('indirizzo');
								}
								if (get_sub_field('citta')) {
									$indirizzo[] = get_sub_field('citta');
								}
								if (get_sub_field('provincia')) {
									$indirizzo[] = get_sub_field('provincia');
								}
								?>
								<div style="display: inline-flex; align-items: center;">
									<img src="https://camperpark.net/wp-content/uploads/2022/04/pin.svg" alt="indirizzo" style="width:12px;">
									<?php if ($indirizzo) : ?>
										<a href="<?php echo esc_url(canva_get_google_map_url(implode(',', $indirizzo))); ?>" style="padding-left:4px;" target="_blank" rel="noopener nofollow"><?php echo implode(', ', $indirizzo); ?></a>
									<?php endif; ?>
								</div>
							</td>

							<td class="tipologia" colspan="3">
								<div style="display: inline-flex; align-items: center;">
									<?php if (get_sub_field('tipologia') == 'sosta') : ?>
										<img src="https://camperpark.net/wp-content/uploads/2022/04/sosta.svg" alt="indirizzo" style="width:24px;">
										<span style="padding-left:4px;">Area di sosta</span>
									<?php else : ?>
										<img src="https://camperpark.net/wp-content/uploads/2022/04/campeggio.svg" alt="indirizzo" style="width:24px;">
										<span style="padding-left:4px;">Campeggio</span>
									<?php endif; ?>
								</div>
							</td>

							<td colspan="1">
								<?php if (get_sub_field('url')) : ?>
									<a href="<?php echo get_sub_field('url'); ?>" target="_blank" rel="noopener nofollow">
										<?php if (is_url_from(get_sub_field('url'), 'facebook')) { ?>
											<img src="https://camperpark.net/wp-content/uploads/2022/04/facebook.svg" alt="facebook" style="width:24px;">
										<?php } else { ?>
											<img src="https://camperpark.net/wp-content/uploads/2022/04/website.svg" alt="sito web" style="width:24px;">
										<?php } ?>
									</a>
								<?php endif; ?>
							</td>
						</tr>

					<?php endwhile; ?>

				</table>
			</div>
		<?php endif; ?>

	</section>

<?php

}
genesis();
