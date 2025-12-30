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
  $default_attr = array(
    'class' => 'hydir-thumbnail',
    'loading' => 'lazy',
  );
  
  $attr = wp_parse_args($attr, $default_attr);
  
  if (has_post_thumbnail($id)) {
    return get_the_post_thumbnail($id, $size, $attr);
  } else {
    // Build attribute string for placeholder
    $attr_string = '';
    foreach ($attr as $name => $value) {
      $attr_string .= ' ' . esc_attr($name) . '="' . esc_attr($value) . '"';
    }
    
    $placeholder_url = apply_filters('hydir_placeholder_image', HYDIR_URL . 'public/img/avatar_blank.jpg');
    $alt_text = apply_filters('hydir_placeholder_alt', __('Placeholder image', 'hydrogen-directory'));
    
    return '<img src="' . esc_url($placeholder_url) . '" alt="' . esc_attr($alt_text) . '"' . $attr_string . ' />';
  }
}
