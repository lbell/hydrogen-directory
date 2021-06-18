<?php
/*
* Register Directory Custom Type
*/
function hydir_register_directory_type() {
	$labels = array(
		'name'               => _x('Directory', 'Post Type General Name', 'hydir'),
		'singular_name'      => _x('Directory', 'Post Type Singular Name', 'hydir'),
		'menu_name'          => __('Directory', 'hydir'),
		'parent_item_colon'  => __('Parent Person', 'hydir'),
		'all_items'          => __('All People', 'hydir'),
		'view_item'          => __('View Person', 'hydir'),
		'add_new_item'       => __('Add New Person', 'hydir'),
		'add_new'            => __('New Person', 'hydir'),
		'edit_item'          => __('Edit Person', 'hydir'),
		'update_item'        => __('Update Person', 'hydir'),
		'search_items'       => __('Search People', 'hydir'),
		'not_found'          => __('No people found', 'hydir'),
		'not_found_in_trash' => __('No people found in Trash', 'hydir'),
	);
	$args = array(
		'label'               => __('prog_person', 'hydir'),
		'description'         => __('Directory', 'hydir'),
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
function hydir_register_role_tax() {
	$labels = array(
		'name'                       => _x('Roles', 'Taxonomy General Name', 'hydir'),
		'singular_name'              => _x('Role', 'Taxonomy Singular Name', 'hydir'),
		'menu_name'                  => __('Roles', 'hydir'),
		'all_items'                  => __('All Roles', 'hydir'),
		'new_item_name'              => __('New Role Name', 'hydir'),
		'add_new_item'               => __('Add New Role', 'hydir'),
		'edit_item'                  => __('Edit Role', 'hydir'),
		'update_item'                => __('Update Role', 'hydir'),
		'separate_items_with_commas' => __('Separate Roles with commas', 'hydir'),
		'search_items'               => __('Search Roles', 'hydir'),
		'add_or_remove_items'        => __('Add or remove Roles', 'hydir'),
		'choose_from_most_used'      => __('Choose from the most used Roles', 'hydir'),
	);
	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'has_archive'       => false,
		'public'            => false,
		'show_ui'           => true,
		'meta_box_cb'       => 'hydir_dropdown_cat_callback', // Dropdown TODO: poss. make this user-selectable?
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
function hydir_add_settings_page() {
	add_submenu_page(
		'edit.php?post_type=directory', //$parent_slug
		'Directory Help',               //$page_title
		'Directory Help',               //$menu_title
		'manage_options',               //$capability
		'directory_help',               //$menu_slug
		'hydir_render_settings_page'  //$function
	);
}


/**
 * Register shortcode(s)
 *
 * @return void
 */
function hydir_register_shortcodes() {
	add_shortcode('program_directory', 'hydir_shortcode');
}


/**
 * Register thumbnail sizes
 *
 * @return void
 */
function hydir_register_thumbnail() {
	add_theme_support('post-thumbnails');
	if (function_exists('add_image_size')) {
		add_image_size('hydir-thumb-100', 100, 100, TRUE);
		add_image_size('hydir-medium-300', 300, 300, TRUE);
	}
}


/**
 * Register front-end styles
 */
function hydir_register_frontend_css() {
	wp_register_style('hydir-css', HYDIR_URL . 'public/css/hydir.css');
}


/**
 * Register front-end scripts
 */
function hydir_register_frontend_js() {
}


/**
 * Register all the things on init
 *
 * @return void
 */
function hydir_init() {
	hydir_register_directory_type();
	hydir_register_role_tax();
	hydir_register_shortcodes();
	hydir_register_thumbnail();
	hydir_register_frontend_css();
	hydir_register_frontend_js();
	hydir_add_settings_page();
}
add_action('init', 'hydir_init', 0);



/**
 * Register admin scripts and styles
 */
function hydir_admin_inits() {
}
// add_action('admin_init', 'hydir_admin_inits');
