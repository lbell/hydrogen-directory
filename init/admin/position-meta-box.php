<?php

/**
 * Add a placement meta box
 * 
 * @return void 
 */
function add_position_meta_box() {
	add_meta_box('position_box', __('Position Title'), 'position_meta_box_content', 'directory', 'normal');
}


/**
 * Create meta box content with text input field to add a position title
 *
 * @param obj $post
 * @return void
 */
function position_meta_box_content($post) {
	wp_nonce_field(basename(__FILE__), 'progdir_position_nonce');

	$curr_value = get_post_meta($post->ID, 'position_title', true);

?>
	<p>
		<label for="position-title"><?php echo __("Position title / description. (Optional)", 'progdir'); ?></label>
		<br />
		<input type="text" class="widefat" name="position-title" id="position-title" value="<?php echo $curr_value ?>" size="30" />
	</p>
<?php
}


/**
 * Save the position metadata
 *
 * @param [type] $post_id
 * @return void 
 */
function position_title_save_meta($post_id) {

	// Verify the nonce before proceeding.
	if (!isset($_POST['progdir_position_nonce']) || !wp_verify_nonce($_POST['progdir_position_nonce'], basename(__FILE__)))
		return $post_id;

	// Check if the current user has permission to edit the post
	if (!current_user_can('edit_post', $post_id))
		return;

	// Get the posted data and sanitize it
	$new_meta_value = (isset($_POST['position-title']) ? sanitize_text_field($_POST['position-title']) : '');
	$meta_key = 'position_title';
	$meta_value = get_post_meta($post_id, $meta_key, true);

	if ($new_meta_value && '' == $meta_value)
		add_post_meta($post_id, $meta_key, $new_meta_value, true);
	elseif ($new_meta_value && $new_meta_value != $meta_value)
		update_post_meta($post_id, $meta_key, $new_meta_value);
	elseif ('' == $new_meta_value && $meta_value)
		delete_post_meta($post_id, $meta_key, $meta_value);
}


/**
 * Register placement metabox on directory post type
 */
add_action('load-post.php', 'position_title_meta_box_setup');
add_action('load-post-new.php', 'position_title_meta_box_setup');

function position_title_meta_box_setup() {
	add_action('add_meta_boxes_directory', 'add_position_meta_box');
	add_action('save_post', 'position_title_save_meta', 10, 2);
}