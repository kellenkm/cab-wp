<?php
/**
 * Comic Arts Brooklyn functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Comic_Arts_Brooklyn
 * @since Comic Arts Brooklyn 1.0
 */

if (function_exists('register_sidebar')) {
	register_sidebar();
}

add_filter('show_admin_bar', '__return_false');

function cab_create_post_types() {
	register_post_type( 'cab_exhibitors',
		array(
			'labels' => array(
				'name' => __( 'CAB Exhibitors' ),
				'singular_name' => __( 'CAB Exhibitor' ),
			),
			'public' => true,
			'menu_position' => 26,
			'has_archive' => true,
			'description' => 'CAB Exhibitors',
			'map_meta_cap' => true,
			'taxonomies' => array('post_tag', 'category'),
			'rewrite' => array('slug'=>'exhibitors'),
			'capability_type' => 'page',
			'hierarchical' => true,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'page-attributes', 'custom-fields', 'revisions', 'excerpt' ),
			'exclude_from_search' => true
		)
	);

	register_post_type( 'cab_calendar_events',
		array(
			'labels' => array(
				'name' => __( 'CAB Calendar Events' ),
				'singular_name' => __( 'CAB Calendar Event' ),
			),
			'public' => true,
			'menu_position' => 26,
			'has_archive' => true,
			'description' => 'CAB Calendar Events',
			'map_meta_cap' => true,
			'taxonomies' => array('post_tag', 'category'),
			'rewrite' => array('slug'=>'calendar-events'),
			'capability_type' => 'page',
			'hierarchical' => true,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'page-attributes', 'custom-fields', 'revisions', 'excerpt' ),
			'exclude_from_search' => true
		)
	);

	// register_post_type( 'cab_appr_types',
	// 	array(
	// 		'labels' => array(
	// 			'name' => __( 'CAB Special Guest Appearance Types' ),
	// 			'singular_name' => __( 'CAB Special Guest Appearance Type' ),
	// 		),
	// 		'public' => true,
	// 		'menu_position' => 26,
	// 		'has_archive' => true,
	// 		'description' => 'CAB Special Guest Appearance Types',
	// 		'map_meta_cap' => true,
	// 		'taxonomies' => array('post_tag', 'category'),
	// 		'rewrite' => array('slug'=>'special-guest-appearance-types'),
	// 		'capability_type' => 'page',
	// 		'hierarchical' => true,
	// 		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'page-attributes', 'custom-fields', 'revisions', 'excerpt' ),
	// 		'exclude_from_search' => true
	// 	)
	// );

	register_post_type( 'cab_locations',
		array(
			'labels' => array(
				'name' => __( 'CAB Locations' ),
				'singular_name' => __( 'CAB Location' ),
			),
			'public' => true,
			'menu_position' => 26,
			'has_archive' => true,
			'description' => 'CAB Locations',
			'map_meta_cap' => true,
			'taxonomies' => array('post_tag', 'category'),
			'rewrite' => array('slug'=>'locations'),
			'capability_type' => 'page',
			'hierarchical' => true,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'page-attributes', 'custom-fields', 'revisions', 'excerpt' ),
			'exclude_from_search' => true
		)
	);

	register_post_type( 'cab_prgm_dates',
		array(
			'labels' => array(
				'name' => __( 'Programming Dates' ),
				'singular_name' => __( 'Programming Dates' ),
			),
			'public' => true,
			'menu_position' => 26,
			'has_archive' => true,
			'description' => 'Programming Dates',
			'map_meta_cap' => true,
			'taxonomies' => array('post_tag', 'category'),
			'rewrite' => array('slug'=>'programming-dates'),
			'capability_type' => 'page',
			'hierarchical' => true,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'page-attributes', 'custom-fields', 'revisions', 'excerpt' ),
			'exclude_from_search' => true
		)
	);

	register_post_type( 'cab_programming',
		array(
			'labels' => array(
				'name' => __( 'Programming' ),
				'singular_name' => __( 'Programming' ),
			),
			'public' => true,
			'menu_position' => 26,
			'has_archive' => true,
			'description' => 'Programming',
			'map_meta_cap' => true,
			'taxonomies' => array('post_tag', 'category'),
			'rewrite' => array('slug'=>'programming'),
			'capability_type' => 'page',
			'hierarchical' => true,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'page-attributes', 'custom-fields', 'revisions', 'excerpt' ),
			'exclude_from_search' => true
		)
	);
}
add_action('init', 'cab_create_post_types');