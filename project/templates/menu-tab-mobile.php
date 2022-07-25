<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

?>

<div class="_nav-tab-mobile">
	<ul class="_tabs w-full inline-flex fixed z-50">
		<li class="_tab px-3 pt-2 pb-1 lh-11 fs-h5 fw-500 w-1/2 active">
			<div class="inline-flex content-center items-center"><a class="_tab-first fs-h3 p-4" href="#tab-first"></a></div>
		</li>
		<li class="_tab px-3 pt-2 pb-1 lh-11 fs-h5 fw-500 w-1/2">
			<div class="inline-flex content-center items-center"><a class="_tab-second fs-h3 p-4" href="#tab-second"></a></div>
		</li>
	</ul>
	<div class="_tab-contents w-full p-4 pt-6 md:p-6 bg-gray-100 min-h-screen pt-24">
		<div id="tab-first" class=""></div>
		<div id="tab-second" class="hidden"></div>
	</div>
</div>
