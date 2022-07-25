<?php
function post_status($value)
{
	if ($value == 0) {
		return 'draft';
	} else {
		return 'publish';
	}
}

function product_dimensions_L($value)
{

	$value = explode('x', $value);

	return $value[0];
}

function product_dimensions_W($value)
{

	$value = explode('x', $value);

	return $value[1];
}

function product_dimensions_H($value)
{

	$value = explode('x', $value);

	return $value[2];
}

function manage_gallery_imgs($value)
{

	$url = 'https://comprex-air.com/media/catalog/product/cache/3dd087bac41fbd47eb574bc81bcda54e';

	$imgs = explode(',', $value);

	if (count($imgs) > 1) {
		$imgs_url = [];
		foreach ($imgs as $img) {
			$imgs_url[] = $url . $img;
		}

		return implode(',', $imgs_url);
	} else {
		return;
	}
}


function manage_additional_attributes($value, $db_slug)
{

	$attrs = explode(',', $value);

	// var_dump($attrs);

		$attrs_new = [];
		foreach ($attrs as $attr) {
			$attr = $attrs = explode('=', $attr);

			// var_dump($attr);

			@$key[] = $attr[0];
			@$val[] = $attr[1];

			$attrs_new[] = array_combine($key, $val);
		}

		$attrs = end($attrs_new);

		if($db_slug){
			return $attrs[$db_slug];
		}else{
			return end($attrs_new);

		}


}

function manage_product_title($value){
	$array = explode('|', $value);
	return $array[0];
}

function clean_html_attributes($value){
	return preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/si",'<$1$2>', $value);
}

function abac_image_changer($value){
	$import_url = 'https://comprex-air.com/media/catalog/product/cache/3dd087bac41fbd47eb574bc81bcda54e';
	$file = basename($value);

	if (false !== strpos($file, 'box1') || false !== strpos($file, 'Box1') || false !== strpos($file, 'hshshsji') || false !== strpos($file, '3dd08') ) {
		return 'https://abc.dadostudio.com/wp-content/uploads/2022/06/placeholder.jpg';
	}else{
		return $import_url . $value;
	}

}
