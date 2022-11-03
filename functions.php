<?php

// add parent and child style
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles() {
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style') );
}

// Remove Google fonts for Twenty Sixteen
if ( ! function_exists( 'twentysixteen_fonts_url' ) ) :
function twentysixteen_fonts_url() {
        return '';
}
endif;

// Add a random backgound image to header
add_action('wp_head', 'add_backgound_image_to_header');
function add_backgound_image_to_header() {
	// absolute path to the child theme directory
	$dir = get_stylesheet_directory() . '/images/headers';

	// allowed image extension
	$ext = array('gif','jpeg','jpg','png');
	if (!empty($ext)) {
		if (!is_array($ext)) {
			$ext = array($ext);
		}
		$ext_match = implode('|', $ext);
	}

	// find all images
	$images = array();
	if ($handle = opendir($dir)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				if (empty($ext) or preg_match('/\.(' . $ext_match . ')$/i', $entry)) {
					$images[] = $entry;
				}
			}
		}
		closedir($handle);
	}
	//print_r($images);

	// select an image by random
	$size = count($images);
	if ( $size > 1 ) {
		$header_image = $images[ rand(0, $size - 1) ];
	} else {
		$header_image = $images[0];
	}

	// url to image in child theme directory
	$image_url = get_stylesheet_directory_uri() . "/images/headers/$header_image";
	//echo "image_url=" . $image_url;
?>
<style type="text/css">
.site-header-main {
	background-image: url("<?php echo $image_url; ?>") !important;
}
</style>
<?php
}


?>
