<?php
/*
* Register Directory Custom Type
*/
function progdir_register_directory_type() {
	$labels = array(
		'name'               => _x('Directory', 'Post Type General Name', 'progdir'),
		'singular_name'      => _x('Directory', 'Post Type Singular Name', 'progdir'),
		'menu_name'          => __('Directory', 'progdir'),
		'parent_item_colon'  => __('Parent Person', 'progdir'),
		'all_items'          => __('All People', 'progdir'),
		'view_item'          => __('View Person', 'progdir'),
		'add_new_item'       => __('Add New Person', 'progdir'),
		'add_new'            => __('New Person', 'progdir'),
		'edit_item'          => __('Edit Person', 'progdir'),
		'update_item'        => __('Update Person', 'progdir'),
		'search_items'       => __('Search People', 'progdir'),
		'not_found'          => __('No people found', 'progdir'),
		'not_found_in_trash' => __('No people found in Trash', 'progdir'),
	);
	$args = array(
		'label'               => __('prog_person', 'progdir'),
		'description'         => __('Directory', 'progdir'),
		'labels'              => $labels,
		'supports'            => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'revisions',
		),
		'taxonomies'          => array('Role'),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 20,
		'menu_icon'             => 'dashicons-id-alt',
		'can_export'          => true,
		'has_archive'         => false, // TODO: Allow to set after install with option?
		'rewrite'             => array('slug' => 'directory'),
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type('directory', $args);
}


/*
* Register Role taxonomy on Person CPT
*/
function progdir_register_role_tax() {
	$labels = array(
		'name'                       => _x('Roles', 'Taxonomy General Name', 'progdir'),
		'singular_name'              => _x('Role', 'Taxonomy Singular Name', 'progdir'),
		'menu_name'                  => __('Roles', 'progdir'),
		'all_items'                  => __('All Roles', 'progdir'),
		'new_item_name'              => __('New Role Name', 'progdir'),
		'add_new_item'               => __('Add New Role', 'progdir'),
		'edit_item'                  => __('Edit Role', 'progdir'),
		'update_item'                => __('Update Role', 'progdir'),
		'separate_items_with_commas' => __('Separate Roles with commas', 'progdir'),
		'search_items'               => __('Search Roles', 'progdir'),
		'add_or_remove_items'        => __('Add or remove Roles', 'progdir'),
		'choose_from_most_used'      => __('Choose from the most used Roles', 'progdir'),
	);
	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'has_archive'       => false,
		'public'            => false,
		'show_ui'           => true,
		'meta_box_cb'       => 'progdir_dropdown_cat_callback', // Dropdown TODO: poss. make this user-selectable?
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => false,
	);
	register_taxonomy('role', 'directory', $args);
}



/**
 * Register submenu item for settings / docs
 * @return void 
 */
function progdir_add_settings_page() {
	add_submenu_page(
		'edit.php?post_type=directory', //$parent_slug
		'Directory Help',               //$page_title
		'Directory Help',               //$menu_title
		'manage_options',               //$capability
		'directory_help',               //$menu_slug
		'progdir_render_settings_page'  //$function
	);
}


/**
 * Register shortcode(s)
 *
 * @return void
 */
function progdir_register_shortcodes() {
	add_shortcode('program_directory', 'progdir_shortcode');
}


/**
 * Register thumbnail sizes
 *
 * @return void
 */
function progdir_register_thumbnail() {
	add_theme_support('post-thumbnails');
	if (function_exists('add_image_size')) {
		add_image_size('progdir-thumb-100', 100, 100, TRUE);
		add_image_size('progdir-medium-300', 300, 300, TRUE);
	}
}


/**
 * Register front-end styles
 */
function progdir_register_frontend_css() {
	wp_register_style('progdir-css', PROGDIR_URL . 'public/css/progdir.css');
}


/**
 * Register front-end scripts
 */
function progdir_register_frontend_js() {
}


/**
 * Register all the things on init
 *
 * @return void
 */
function progdir_init() {
	progdir_register_directory_type();
	progdir_register_role_tax();
	progdir_register_shortcodes();
	progdir_register_thumbnail();
	progdir_register_frontend_css();
	progdir_register_frontend_js();
	progdir_add_settings_page();
}
add_action('init', 'progdir_init', 0);



/**
 * Register admin scripts and styles
 */
function progdir_admin_inits() {
}
// add_action('admin_init', 'progdir_admin_inits');
