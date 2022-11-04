<?php

// add parent and child style
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles() {
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style') );
}

// child setup theme
function twentysixteenable_child_setup() {
	// Add support for editor styles
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'twentysixteenable_child_setup' );

// Remove Google fonts for Twenty Sixteen
if ( ! function_exists( 'twentysixteen_fonts_url' ) ) :
function twentysixteen_fonts_url() {
        return '';
}
endif;

function files_scan($path, $ext = false) {
	if (!empty($ext)) {
		if (!is_array($ext)) {
			$ext = array($ext);
		}
		$ext_match = implode('|', $ext);
	}

	// find all files
	$files = array();
	if ($handle = opendir($path)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				if (empty($ext) or preg_match('/\.(' . $ext_match . ')$/i', $entry)) {
					$files[] = $entry;
				}
			}
		}
		closedir($handle);
	}

	//print_r($files);
	return $files;
}

function get_header_image_url(){
	// absolute path to the child theme directory
	$dir = get_stylesheet_directory() . '/images/headers';

	// allowed image extension
	$ext = array('gif','jpeg','jpg','png');

	// all images in directory
	$images = files_scan($dir, $ext);

	// select an image by random
	$size = count($images);
	if ( $size > 1 ) {
		$header_image = $images[ rand(0, $size - 1) ];
	} else {
		$header_image = $images[0];
	}

	//echo "image_url=" . $image_url;
        if ( empty($header_image) )
		return false;

	// url to image in child theme directory
	return get_stylesheet_directory_uri() . "/images/headers/$header_image";
}

// Add a random background image to header
add_action('wp_head', 'add_background_image_to_header');
function add_background_image_to_header() {
	$image_url = get_header_image_url();
	if ( $image_url ):
?>
<style media="screen">.site-header-main { background-image: url("<?php echo $image_url; ?>"); }</style>
<?php
	endif;
}


?>
