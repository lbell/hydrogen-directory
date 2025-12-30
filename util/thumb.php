<?php
if (! defined('ABSPATH')) exit;

/**
 * Get the thumbnail for a directory entry
 * 
 * Returns the featured image or a placeholder avatar if none exists.
 * 
 * @param int    $id   The post ID
 * @param string $size The image size (default: "hydir-thumb-100")
 * @param array  $attr Additional attributes for the image
 * @return string HTML img tag
 */
function hydir_thumb($id, $size = "hydir-thumb-100", $attr = array()) {
  /**
   * Filter the default thumbnail size.
   *
   * @since 1.2.0
   * @param string $size The image size name.
   * @param int    $id   The post ID.
   */
  $size = apply_filters('hydir_thumbnail_size', $size, $id);

  $default_attr = array(
    'class' => 'hydir-thumbnail',
    'loading' => 'lazy',
  );

  /**
   * Filter the default thumbnail attributes.
   *
   * @since 1.2.0
   * @param array $default_attr Default attributes.
   * @param int   $id           The post ID.
   * @param string $size        The image size.
   */
  $default_attr = apply_filters('hydir_thumbnail_default_attr', $default_attr, $id, $size);

  $attr = wp_parse_args($attr, $default_attr);

  if (has_post_thumbnail($id)) {
    $thumbnail = get_the_post_thumbnail($id, $size, $attr);

    /**
     * Filter the thumbnail HTML when a featured image exists.
     *
     * @since 1.2.0
     * @param string $thumbnail The thumbnail HTML.
     * @param int    $id        The post ID.
     * @param string $size      The image size.
     * @param array  $attr      The image attributes.
     */
    return apply_filters('hydir_thumbnail_html', $thumbnail, $id, $size, $attr);
  } else {
    // Build attribute string for placeholder
    $attr_string = '';
    foreach ($attr as $name => $value) {
      $attr_string .= ' ' . esc_attr($name) . '="' . esc_attr($value) . '"';
    }

    $placeholder_url = apply_filters('hydir_placeholder_image', HYDIR_URL . 'public/img/avatar_blank.jpg');
    $alt_text = apply_filters('hydir_placeholder_alt', __('Placeholder image', 'hydrogen-directory'));

    $placeholder_html = '<img src="' . esc_url($placeholder_url) . '" alt="' . esc_attr($alt_text) . '"' . $attr_string . ' />';

    /**
     * Filter the placeholder thumbnail HTML.
     *
     * @since 1.2.0
     * @param string $placeholder_html The placeholder HTML.
     * @param int    $id               The post ID.
     * @param string $size             The image size.
     * @param array  $attr             The image attributes.
     */
    return apply_filters('hydir_placeholder_html', $placeholder_html, $id, $size, $attr);
  }
}
