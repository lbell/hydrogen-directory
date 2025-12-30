<?php

/**
 * Server-side rendering of the Hydrogen Directory block.
 *
 * @package hydrogen-directory
 */

if (! defined('ABSPATH')) exit;

// Get attributes with defaults
$taxonomy       = isset($attributes['taxonomy']) ? sanitize_text_field($attributes['taxonomy']) : 'role';
$terms          = isset($attributes['terms']) ? sanitize_text_field($attributes['terms']) : '';
$style          = isset($attributes['style']) ? sanitize_text_field($attributes['style']) : 'list';
$columns        = isset($attributes['columns']) ? absint($attributes['columns']) : 1;
$show_headers   = isset($attributes['showHeaders']) ? (bool) $attributes['showHeaders'] : true;
$content_mode   = isset($attributes['content']) ? sanitize_text_field($attributes['content']) : 'excerpt';
$excerpt_length = isset($attributes['excerptLength']) ? absint($attributes['excerptLength']) : 20;

// Convert boolean to string for shortcode compatibility
$headers = $show_headers ? '1' : '0';

// Enqueue styles
wp_enqueue_style('hydir-css');
if ($style === 'card' || $style === 'list') {
  wp_enqueue_style('list-card-css');
}

// Handle multiple terms
$output = '';
if (!empty($terms)) {
  $term_array = array_filter(array_map('trim', explode(',', $terms)));
  foreach ($term_array as $term) {
    $term_output = hydir_display($taxonomy, $term, $columns, 'all', $style, $headers, $content_mode, $excerpt_length);
    // Only add output if it's not an error message (term has entries)
    if (!empty($term_output) && strpos((string) $term_output, 'Error') === false) {
      $output .= $term_output;
    }
  }
} else {
  // No specific terms - show all
  $result = hydir_display($taxonomy, null, $columns, 'all', $style, $headers, $content_mode, $excerpt_length);
  // Check if the result is an error
  if (!empty($result) && strpos((string) $result, 'Error') === false) {
    $output = $result;
  }
}

// Wrap in block wrapper
$wrapper_attributes = get_block_wrapper_attributes(array(
  'class' => 'hydir-block hydir-block-' . esc_attr($style)
));

printf(
  '<div %1$s>%2$s</div>',
  $wrapper_attributes,
  $output
);
