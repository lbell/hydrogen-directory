<?php
if (! defined('ABSPATH')) exit;

/**
 * Add a placement meta box
 * 
 * @return void 
 */
function hydir_add_position_meta_box() {
  /**
   * Filter whether to show the position meta box.
   *
   * @since 1.2.0
   * @param bool $show Whether to show the meta box.
   */
  if (!apply_filters('hydir_show_position_meta_box', true)) {
    return;
  }

  add_meta_box(
    'position_box', 
    /**
     * Filter the position meta box title.
     *
     * @since 1.2.0
     * @param string $title The meta box title.
     */
    apply_filters('hydir_position_meta_box_title', __('Position Title', 'hydrogen-directory')),
    'hydir_position_meta_box_content', 
    'hy_directory', 
    'normal'
  );

  /**
   * Fires after the position meta box is added.
   * Use this hook to add additional meta boxes.
   *
   * @since 1.2.0
   */
  do_action('hydir_after_position_meta_box');
}


/**
 * Create meta box content with text input field to add a position title
 *
 * @param obj $post
 * @return void
 */
function hydir_position_meta_box_content($post) {
  wp_nonce_field(basename(__FILE__), 'hydir_position_nonce');

  $curr_value = get_post_meta($post->ID, 'position_title', true);

  /**
   * Filter the position field label.
   *
   * @since 1.2.0
   * @param string $label The field label.
   */
  $label = apply_filters('hydir_position_field_label', __('Position title / description. (Optional)', 'hydrogen-directory'));

?>
  <p>
    <label for="position-title"><?php echo esc_html($label); ?></label>
    <br />
    <input type="text" class="widefat" name="position-title" id="position-title" value="<?php echo esc_attr($curr_value) ?>" size="30" />
  </p>
  <?php
  /**
   * Fires after the position meta box content.
   * Use this hook to add additional fields to the meta box.
   *
   * @since 1.2.0
   * @param WP_Post $post The current post object.
   */
  do_action('hydir_position_meta_box_fields', $post);
  ?>
<?php
}


/**
 * Save the position metadata
 *
 * @param [type] $post_id
 * @return void 
 */
function hydir_save_position_meta($post_id) {

  // Verify the nonce before proceeding.
  if (!isset($_POST['hydir_position_nonce']) || !wp_verify_nonce(wp_unslash(sanitize_key($_POST['hydir_position_nonce'])), basename(__FILE__)))
    return $post_id;

  // Check if the current user has permission to edit the post
  if (!current_user_can('edit_post', $post_id))
    return;

  // Get the posted data and sanitize it
  $new_meta_value = (isset($_POST['position-title']) ? sanitize_text_field(wp_unslash($_POST['position-title'])) : '');

  /**
   * Filter the position meta value before saving.
   *
   * @since 1.2.0
   * @param string $new_meta_value The sanitized position value.
   * @param int    $post_id        The post ID.
   */
  $new_meta_value = apply_filters('hydir_save_position_value', $new_meta_value, $post_id);

  $meta_key = 'position_title';
  $meta_value = get_post_meta($post_id, $meta_key, true);

  if ($new_meta_value && '' == $meta_value)
    add_post_meta($post_id, $meta_key, $new_meta_value, true);
  elseif ($new_meta_value && $new_meta_value != $meta_value)
    update_post_meta($post_id, $meta_key, $new_meta_value);
  elseif ('' == $new_meta_value && $meta_value)
    delete_post_meta($post_id, $meta_key, $meta_value);

  /**
   * Fires after the position meta is saved.
   * Use this hook to save additional custom meta fields.
   *
   * @since 1.2.0
   * @param int    $post_id   The post ID.
   * @param string $new_value The new position value.
   * @param string $old_value The old position value.
   */
  do_action('hydir_after_save_position', $post_id, $new_meta_value, $meta_value);
}


/**
 * Register placement metabox on directory post type
 */
add_action('load-post.php', 'hydir_position_meta_setup');
add_action('load-post-new.php', 'hydir_position_meta_setup');

function hydir_position_meta_setup() {
  add_action('add_meta_boxes_hy_directory', 'hydir_add_position_meta_box');
  add_action('save_post', 'hydir_save_position_meta', 10, 2);
}
