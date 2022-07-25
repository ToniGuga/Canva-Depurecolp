<?php if (get_the_content($post_id)) : ?>

	<article class="relative bg-black ratio-full-hd overflow-hidden hover:bg-gray-900 transition-all duration-200 ease-in-out">

		<a href=" <?php echo get_permalink($post_id); ?>">

			<?php
			echo canva_get_img([
				'img_id'        =>  $post_id,
				'thumb_size'      =>  '160-free',
				'wrapper_class' =>  'absolute top-0 left-0 z-1 w-full h-full opacity-50'
			]);
			?>

			<div class="absolute top-0 left-0 z-2 w-full h-full p-6 flex flex-col justify-between">

				<h5 class="text-white uppercase">
					<?php echo get_the_title($post_id); ?>
				</h5>

			</div>

		</a>

	</article>

<?php endif; ?>
