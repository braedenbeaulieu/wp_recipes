<?php

function rc_enqueue_public_scripts() {
    //wp_enqueue_script( 'rc-public', plugins_url().'/rc/js/rc-public.min.js', 'jquery', null, true );
    wp_enqueue_style( 'app-font', 'https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700,800&display=swap', null, null, null );
	wp_enqueue_style( 'rc-public', get_template_directory_uri() . '/css/app.min.css', null, null, null );
}
add_action('init', 'rc_enqueue_public_scripts');

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
		'all_items'             => __( 'All Recipe', 'rp' ),
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
		'supports'              => array( 'title', 'editor' ),
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