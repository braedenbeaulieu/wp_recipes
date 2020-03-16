<?php

if (!defined('ABSPATH'))  die( '-1' );

function rc_enqueue_public_scripts() {
    wp_enqueue_style( 'app-font', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,800&display=swap', null, null, null );
	wp_enqueue_style( 'rc-public', get_template_directory_uri() . '/css/app.min.css', null, null, null );
	wp_enqueue_script( 'rc-public-js', get_template_directory_uri() . '/js/app.min.js', array( 'jquery' ) );
	wp_enqueue_script('jquery');
	wp_localize_script( 'rc-public-js', 'localized_vars', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
}
add_action('init', 'rc_enqueue_public_scripts');

// Register new images sizes
function rp_image_size_setup() {
    add_image_size( 'rp-md', 450, 450, array( 'center', 'center' ), false );
	add_image_size( 'rp-lg', 1920, 500, array( 'center', 'center' ) );
}
add_action( 'after_setup_theme', 'rp_image_size_setup' );


function rp_add_theme_support() {
	add_theme_support('post-thumbnails');
	add_theme_support('html5', array(
		'search-form',
		'gallery',
		'caption'
	));
}
add_action( 'after_setup_theme', 'rp_add_theme_support' );

//Remove the built-in image size settings
function rp_disable_image_sizes($sizes) {
    unset($sizes['medium']);
    unset($sizes['large']);
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
}
add_action('intermediate_image_sizes_advanced', 'rp_disable_image_sizes');

// Register Custom Post Type
function rp_register_recipes_post_type() {

	$labels = array(
		'name'                  => _x( 'Recipes', 'Post Type General Name', 'rp' ),
		'singular_name'         => _x( 'Recipe', 'Post Type Singular Name', 'rp' ),
		'menu_name'             => __( 'Recipes', 'rp' ),
		'name_admin_bar'        => __( 'Recipe', 'rp' ),
		'archives'              => __( 'Recipe Archives', 'rp' ),
		'attributes'            => __( 'Recipe Attributes', 'rp' ),
		'parent_item_colon'     => __( 'Parent Item:', 'rp' ),
		'all_items'             => __( 'All Recipes', 'rp' ),
		'add_new_item'          => __( 'Add New Recipe', 'rp' ),
		'add_new'               => __( 'Add New', 'rp' ),
		'new_item'              => __( 'New Recipe', 'rp' ),
		'edit_item'             => __( 'Edit Recipe', 'rp' ),
		'update_item'           => __( 'Update Recipe', 'rp' ),
		'view_item'             => __( 'View Recipe', 'rp' ),
		'view_items'            => __( 'View Recipes', 'rp' ),
		'search_items'          => __( 'Search Recipes', 'rp' ),
		'not_found'             => __( 'Not found', 'rp' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'rp' ),
		'featured_image'        => __( 'Featured Image', 'rp' ),
		'set_featured_image'    => __( 'Set featured image', 'rp' ),
		'remove_featured_image' => __( 'Remove featured image', 'rp' ),
		'use_featured_image'    => __( 'Use as featured image', 'rp' ),
		'insert_into_item'      => __( 'Insert into Recipe', 'rp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Recipe', 'rp' ),
		'items_list'            => __( 'Recipes list', 'rp' ),
		'items_list_navigation' => __( 'Recipes list navigation', 'rp' ),
		'filter_items_list'     => __( 'Filter recipes list', 'rp' ),
	);
	$args = array(
		'label'                 => __( 'Recipe', 'rp' ),
		'description'           => __( 'Recipes post type', 'rp' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-carrot',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'recipe', $args );

}
add_action( 'init', 'rp_register_recipes_post_type', 0 );

function rp_get_quantity($quantity) {
	$quantity_arr = explode('.', $quantity);
	$number = $quantity_arr[0];
	$decimal = $quantity_arr[1];

	switch($decimal) {
		case '25':
			$decimal = '1/4';
			break;
		case '5':
			$decimal = '1/2';
			break;
		case '75':
			$decimal = '3/4';
			break;
		case '20':
			$decimal = '1/5';
			break;
		case '125':
			$decimal = '1/8';
			break;
	}

	return $number . ' ' . $decimal;
}


function rp_get_cook_time($time) {
	if($time == 60) {
		return '1 hr'; 
	} else if($time < 60) {
		if($time > 1) {
			return $time . ' mins';
		} else {
			return $time . ' min';
		}
	} else if($time > 60) {
		// how many hours is it, find the multiple of 60 and keep the remainer as minutes
		$hours = 0;
		$minutes = 0;
		while($time > 60) {
			$time -= 60;
			$minutes = $time;
			$hours++;
		}

		if($hours > 1) {
			$hr = 'hrs';
		} else {
			$hr = 'hr';
		}
		if($minutes > 1) {
			$min = 'mins';
		} else {
			$min = 'min';
		}

		return $hours . ' ' . $hr . ' '. $minutes . ' ' . $min;
		
	}
}

function get_made_its($amount) {
	if($amount >= 1000000) {
		return number_format($amount / 1000000, 1, '.', '') . 'M';
	} else if($amount >= 1000) {
		return floor($amount / 1000) . 'K';
	} else {
		return $amount;
	}
}

function made_it() {
	// nonce check for an extra layer of security, the function will exit if it fails
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'made_it_nonce')) {
	   exit('Woof Woof Woof');
	}   
	
	// fetch made_it_count for a post, set it to 0 if it's empty, increment by 1 when a click is registered 
	$made_it_count = get_post_meta($_REQUEST['post_id'], 'made_its', true);
	$made_it_count = ($made_it_count == ’) ? 0 : $made_it_count;
	$new_made_it_count = $made_it_count + 1;
	
	// Update the value of 'made_its' meta key for the specified post, creates new meta data for the post if none exists
	$made_it = update_post_meta($_REQUEST['post_id'], 'made_its', $new_made_it_count);
	
	// If above action fails, result type is set to 'error' and made_it_count set to old value, if success, updated to new_made_it_count  
	if($made_it === false) {
	   $result['type'] = 'error';
	   $result['made_it_count'] = $made_it_count;
	}
	else {
	   $result['type'] = 'success';
	   $result['made_it_count'] = $new_made_it_count;
	}
	
	// Check if action was fired via Ajax call. If yes, JS code will be triggered, else the user is redirected to the post page
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	   $result = json_encode($result);
	   echo $result;
	}
	else {
	   header('Location: '.$_SERVER['HTTP_REFERER']);
	}
 
	// don't forget to end your scripts with a die() function - very important
	die();
}
add_action('wp_ajax_made_it', 'made_it');
add_action('wp_ajax_nopriv_made_it', 'made_it');