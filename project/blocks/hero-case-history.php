
<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (is_admin()) {

	if (!$is_preview) {
		/* rendering in inserter preview  */
		echo '<img src="' . CANVA_PROJECT_BLOCKS_URI . '/previews/' . basename($block['name']) . '.jpg" class="block-preview" style="width:100%; height:auto;">';
	}

?>

	<div class="canva-wp-block canva-flex">

		<div class="info canva-width-24 canva-p-4">

			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">
				<?php _e('Hero Case History', 'canva-backend'); ?>
			</span>

			<figure class="canva-width-12 canva-m-0">

				<!-- Icona -->
				<?php echo apply_filters('hero_two_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-hero-2', null)); ?>
				<!-- Fine Icona -->

			</figure>

		</div>

		<div class="_content canva-flex-1 canva-p-4">

				<!-- < class="canva-block-icon-text canva-flex"> -->

					<div class="canva-icon canva-mr-6 canva-mt-3">
						<?php
						echo canva_get_img([
							'img_id' => get_field('image'),
							'img_type' => 'img', // img, bg, url
							'thumb_size' => '640-free',
							'wrapper_class' => 'canva-width-24 canva-p-0 canva-m-0 canva-mr-4',
							'img_class' => '',
							'bg_content' => '',
							'caption' => 'off',
							'blazy' => 'off',
							'srcset' => 'off',
							'data_attr' => '',
							'width' => '',
							'height' => '',
						]);
						?>
					</div>

					<div class="canva-info canva-flex-1 canva-ml-4">

						<span class="canva-block canva-mb-2 canva-fs-h2 canva-font-theme canva-fw-700 canva-lh-11">
							<?php the_field('title'); ?>
						</span>

						<span class="canva-block canva-fs-h4 canva-font-theme canva-lh-11">
							<?php the_field('subtitle'); ?>
						</span>

							<InnerBlocks />

					</div>



					<div class="canva-info canva-flex-1 canva-ml-4">

					<span class=""></span>




					</div>
				



				</div>
		</div>

	</div>

<?php } else { 

	// Create id attribute allowing for custom "anchor" value.
	$id = $block['
    id'];
	if (!empty($block['anchor'])) {
		$id = $block['anchor'];
	}

	// Create class attribute allowing for custom "className" and "align" values.
	$className = '';
	if (!empty($block['className'])) {
		$className .= ' ' . $block['className'];
	} ?>



<div class="_row bg-gray-200 p-4 rounded-lg">

    <?php if (get_field('image')) { ?>

       <div class="_col w-full md:w-1/2">
            <?php
			echo canva_get_img([
				'img_id' => get_field('image'),
				'img_type' => 'img', // img, bg, url
				'thumb_size' => '320-11',
				'wrapper_class' => '',
				'img_class' => '',
				'bg_content' => '',
				'caption' => 'off',
				'blazy' => 'on',
				'srcset' => 'off	',
				'data_attr' => '',
				'width' => '',
				'height' => '',
			]);
			?>

        </div>

    <? } ?>

    <div class="_col w-full md:w-1/2">

		<?php if (get_field('title')) { ?>
			<h1>
				<span class="block"></span><?php echo get_field('title'); ?></span>
				<?php if (get_field('subtitle')) { ?>
					<span class="block fs-h4 mt-2"><?php echo get_field('subtitle'); ?></span>
				<? } ?>
			</h1>
		<? } ?>

		
        <InnerBlocks />
    </div>
    


</div>

<? }