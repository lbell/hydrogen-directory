<?php
/*
* Register Directory Custom Type
*/
function hydir_register_directory_type() {
	$labels = array(
		'name'               => _x('Directory', 'Post Type General Name', 'hydir'),
		'singular_name'      => _x('Directory', 'Post Type Singular Name', 'hydir'),
		'menu_name'          => __('Directory', 'hydir'),
		'parent_item_colon'  => __('Parent Entry', 'hydir'),
		'all_items'          => __('All Entries', 'hydir'),
		'view_item'          => __('View Entry', 'hydir'),
		'add_new_item'       => __('Add New Entry', 'hydir'),
		'add_new'            => __('New Entry', 'hydir'),
		'edit_item'          => __('Edit Entry', 'hydir'),
		'update_item'        => __('Update Entry', 'hydir'),
		'search_items'       => __('Search Entries', 'hydir'),
		'not_found'          => __('No entries found', 'hydir'),
		'not_found_in_trash' => __('No entries found in Trash', 'hydir'),
	);
	$args = array(
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
		// 'menu_icon'             => 'dashicons-id-alt',
		'menu_icon'           => 'data:image/svg+xml;base64,' . base64_encode('<svg width="20mm" height="20mm" version="1.1" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
		<g transform="matrix(1.0001 0 0 1.0001 133.15 -53.684)">
		 <path fill="black" d="m-123.61 55.89-4.1005 5.3e-4c-2.254 2.91e-4 -4.2132 9e-3 -4.3532 0.01912-0.232 0.0168-0.26721 0.02487-0.40721 0.09457-0.205 0.1006-0.426 0.32065-0.555 0.55345l-0.0935 0.16743-0.0134 4.3506c-6e-3 2.3931-0.0129 5.3909-0.0129 6.6626v2.3125l0.0481 0.12919c0.07 0.183 0.1183 0.27293 0.2253 0.41703 0.146 0.193 0.38455 0.3594 0.60255 0.4191 0.04 0.0107 0.39397 0.02621 0.78497 0.03411v-5.3e-4c0.394 0.0079 1.0741 0.01609 1.5131 0.01809l0.7984 0.0041 0.0129-0.26045c6e-3 -0.143 0.0129-0.32071 0.0129-0.39481v-0.13488l0.10801-0.01292c0.059-7e-3 0.23787-0.01324 0.39687-0.01344h0.29094v0.81649h10.409v-0.81649h0.28991c0.16 2e-4 0.33891 0.0065 0.39791 0.01344l0.10697 0.01292v0.14676c0 0.0808 5e-3 0.26043 0.0139 0.39843l0.0129 0.25115 1.3994-0.01395c0.769-0.0079 1.4759-0.02372 1.5699-0.03462 0.199-0.0241 0.33394-0.08014 0.50694-0.21084 0.197-0.1487 0.35175-0.37169 0.45475-0.65629l0.0434-0.12351-9e-3 -5.6002c-8e-3 -5.7222-0.0108-5.9129-0.0847-6.21-0.055-0.2114-0.29501-0.47434-0.58601-0.63924l-0.15296-0.0863-4.3744-0.02274c-2.405-0.0123-4.3766-0.02396-4.3786-0.02636-3e-3 -0.0022-0.0134-0.13269-0.0274-0.28939-0.032-0.434-0.0867-0.61825-0.23771-0.81856-0.103-0.1366-0.2339-0.24412-0.4439-0.36122zm-4.2147 3.7564c0.37 0 0.67635 0.2703 0.73535 0.6227 1.838 0.3442 3.2288 1.9574 3.2288 3.8959 0 2.1895-1.7731 3.9646-3.9641 3.9646s-3.9641-1.7751-3.9641-3.9646c0-1.9385 1.3913-3.552 3.2303-3.8964 0.059-0.3522 0.36481-0.62218 0.73381-0.62218zm-0.72967 0.87333c-1.703 0.3395-2.9864 1.8428-2.9864 3.6453 0 2.0528 1.663 3.7166 3.716 3.7166s3.7171-1.664 3.7171-3.7166c0-1.8025-1.2839-3.3058-2.9869-3.6453-0.061 0.3494-0.36319 0.6134-0.73019 0.6134s-0.66867-0.2643-0.72967-0.6134zm6.0999 1.2268 1.1782 0.01344c0.647 0.0074 2.2688 0.01344 3.6008 0.01344h2.4241v0.76946l-0.25993 0.01292c-0.144 0.0072-1.7644 0.01344-3.6034 0.01344h-3.3398v-0.41134zm-5.4022 0.94671c0.822 0 1.4872 0.66531 1.4872 1.4862 0 0.8211-0.66525 1.4867-1.4872 1.4867s-1.4872-0.66563-1.4872-1.4867c0-0.8209 0.66525-1.4862 1.4872-1.4862zm9.0144 1.0738c1.7878 7.12e-4 3.5753 0.0057 3.5838 0.01447 7e-3 0.0061 0.0162 0.18586 0.0222 0.39946l0.0109 0.38861h-7.2362l0.0114-0.38809c4e-3 -0.2131 0.0148-0.39406 0.0238-0.40256 8e-3 -0.0087 1.7965-0.0126 3.5843-0.01189zm3.6096 2.0061v0.79582h-7.2249l7e-3 -0.39274 4e-3 -0.39274 3.607-0.0052z" stroke-width="2.1862"/>
		</g>
	   </svg>
	   '),
		'can_export'          => true,
		'has_archive'         => false, // TODO: Allow to set after install with option?
		'rewrite'             => array('slug' => 'directory'),
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type('hy_directory', $args);
}


/*
* Register Role taxonomy on Directory CPT
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
	register_taxonomy('role', 'hy_directory', $args);
}



/**
 * Register submenu item for settings / docs
 * @return void 
 */
function hydir_add_settings_page() {
	add_submenu_page(
		'edit.php?post_type=hy_directory', //$parent_slug
		'Directory Help',                  //$page_title
		'Directory Help',                  //$menu_title
		'manage_options',                //$capability
		'directory_help',                  //$menu_slug
		'hydir_render_settings_page'       //$function
	);
}


/**
 * Register shortcode(s)
 *
 * @return void
 */
function hydir_register_shortcodes() {
	add_shortcode('hydrogen_directory', 'hydir_shortcode');
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
	wp_register_style('hydir-css', HYDIR_URL . 'public/css/hydir.css', null, HYDIR_VER);
	wp_register_style('list-card-css', HYDIR_URL . 'public/css/list-card.css', null, HYDIR_VER);
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
}
add_action('init', 'hydir_init', 0);


/**
 * Register admin styles
 */
function hydir_register_admin_css() {
	wp_register_style('hydir-admin-css', HYDIR_URL . 'public/css/hydir-admin.css', null, HYDIR_VER);
	wp_enqueue_style('hydir-admin-css');
}


/**
 * Register admin scripts and styles
 */
function hydir_admin_inits() {
	hydir_register_admin_css();
}
add_action('admin_init', 'hydir_admin_inits');


/**
 * Register admin submenu item for settings / docs
 */
function hydir_admin_menu_inits() {
	hydir_add_settings_page();
}
add_action('admin_menu', 'hydir_admin_menu_inits');
