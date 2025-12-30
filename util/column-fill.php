<?php
if (! defined('ABSPATH')) exit;

/**
 * Creates wp-block-columns of a given number, and backfills with empty columns
 *
 * @param array $posts Array of WP post objects
 * @param int $columns Number of columns to display
 * @param string $style Template style (list, card, text, etc)
 * @param string $content Content display mode (full, excerpt, or none)
 * @param int $excerpt_length Words to show in excerpt
 * @return void echos instead of returns to be captured by ob_start();
 */
function hydir_column_fill($posts, $columns, $style, $content = "excerpt", $excerpt_length = 20) {

  // Apply content filters for list and card styles
  if ($style === 'list' || $style === 'card') {
    // Determine if we should show content and if full or excerpt
    $show_content = $content !== 'none';
    $full_content = $content === 'full';

    add_filter('hydir_content_mode', function ($default) use ($content) {
      return $content;
    });
    add_filter('hydir_excerpt_length', function ($default) use ($excerpt_length) {
      return absint($excerpt_length);
    });

    // Legacy list filters for backwards compatibility
    add_filter('hydir_list_show_content', function ($default) use ($show_content) {
      return $show_content;
    });
    add_filter('hydir_list_full_content', function ($default) use ($full_content) {
      return $full_content;
    });
    add_filter('hydir_list_excerpt_length', function ($default) use ($excerpt_length) {
      return absint($excerpt_length);
    });

    // Card filters
    add_filter('hydir_card_show_content', function ($default) use ($show_content) {
      return $show_content;
    });
    add_filter('hydir_card_full_content', function ($default) use ($full_content) {
      return $full_content;
    });
    add_filter('hydir_card_excerpt_length', function ($default) use ($excerpt_length) {
      return absint($excerpt_length);
    });
  }

  $array_chunks = array_chunk($posts, $columns);
  $template_name = "directory-list-entry-" . $style;
  $template_exists = hydir_get_template_part($template_name);

  foreach ($array_chunks as $posts) {
    echo '<div class="wp-block-columns hydir-columns hydir-columns-' . esc_attr($style) . ' hydir-columns-' . absint($columns) . ' hydir-columns-' . esc_attr($style) . '-' . absint($columns) . '">';
    foreach ($posts as $post) {
      echo '<div class="wp-block-column hydir-column hydir-column-' . esc_attr($style) . '">';

      if (is_null($template_exists)) {
        include hydir_get_template_part('directory-list-entry-list');
      } else {
        include hydir_get_template_part($template_name);
      }
      echo '</div>';
    }
    for ($i = 0; $i < ($columns - count($posts)); $i++) {
      echo '<div class="wp-block-column hydir-column hydir-column-empty">';
      echo '</div>';
    }
    echo '</div>';
  }
}
