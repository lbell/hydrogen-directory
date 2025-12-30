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

  /**
   * Filter the posts before column fill processing.
   *
   * @since 1.2.0
   * @param array  $posts   Array of post objects.
   * @param string $style   The display style.
   * @param int    $columns Number of columns.
   */
  $posts = apply_filters('hydir_column_fill_posts', $posts, $style, $columns);

  /**
   * Filter the number of columns.
   *
   * @since 1.2.0
   * @param int    $columns Number of columns.
   * @param string $style   The display style.
   * @param int    $count   Number of posts.
   */
  $columns = apply_filters('hydir_columns_count', $columns, $style, count($posts));

  // Apply content filters for list, card, and text styles
  if ($style === 'list' || $style === 'card' || $style === 'text') {
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

    // Text filters
    add_filter('hydir_text_show_content', function ($default) use ($show_content) {
      return $show_content;
    });
    add_filter('hydir_text_full_content', function ($default) use ($full_content) {
      return $full_content;
    });
    add_filter('hydir_text_excerpt_length', function ($default) use ($excerpt_length) {
      return absint($excerpt_length);
    });
  }

  $array_chunks = array_chunk($posts, $columns);
  $template_name = "directory-list-entry-" . $style;
  $template_exists = hydir_get_template_part($template_name);

  /**
   * Fires before the columns output begins.
   *
   * @since 1.2.0
   * @param array  $posts   Array of post objects.
   * @param string $style   The display style.
   * @param int    $columns Number of columns.
   */
  do_action('hydir_before_columns', $posts, $style, $columns);

  foreach ($array_chunks as $chunk_index => $posts) {
    /**
     * Filter the CSS classes for the row wrapper.
     *
     * @since 1.2.0
     * @param string $classes     Space-separated CSS classes.
     * @param string $style       The display style.
     * @param int    $columns     Number of columns.
     * @param int    $chunk_index The row index (0-based).
     */
    $row_classes = apply_filters(
      'hydir_row_classes',
      'wp-block-columns hydir-columns hydir-columns-' . esc_attr($style) . ' hydir-columns-' . absint($columns) . ' hydir-columns-' . esc_attr($style) . '-' . absint($columns),
      $style,
      $columns,
      $chunk_index
    );

    echo '<div class="' . esc_attr($row_classes) . '">';

    /**
     * Fires at the start of each row, before entries.
     *
     * @since 1.2.0
     * @param array  $posts       Posts in this row.
     * @param int    $chunk_index The row index.
     * @param string $style       The display style.
     */
    do_action('hydir_before_row', $posts, $chunk_index, $style);

    foreach ($posts as $post_index => $post) {
      /**
       * Filter the CSS classes for the column wrapper.
       *
       * @since 1.2.0
       * @param string   $classes    Space-separated CSS classes.
       * @param string   $style      The display style.
       * @param WP_Post  $post       The post object.
       * @param int      $post_index The index of this entry in the row.
       */
      $column_classes = apply_filters(
        'hydir_column_classes',
        'wp-block-column hydir-column hydir-column-' . esc_attr($style),
        $style,
        $post,
        $post_index
      );

      echo '<div class="' . esc_attr($column_classes) . '">';

      /**
       * Fires before each entry is rendered.
       *
       * @since 1.2.0
       * @param WP_Post $post  The post object.
       * @param string  $style The display style.
       */
      do_action('hydir_before_entry', $post, $style);

      if (is_null($template_exists)) {
        include hydir_get_template_part('directory-list-entry-list');
      } else {
        include hydir_get_template_part($template_name);
      }

      /**
       * Fires after each entry is rendered.
       *
       * @since 1.2.0
       * @param WP_Post $post  The post object.
       * @param string  $style The display style.
       */
      do_action('hydir_after_entry', $post, $style);

      echo '</div>';
    }

    for ($i = 0; $i < ($columns - count($posts)); $i++) {
      echo '<div class="wp-block-column hydir-column hydir-column-empty">';
      echo '</div>';
    }

    /**
     * Fires at the end of each row, after entries.
     *
     * @since 1.2.0
     * @param array  $posts       Posts in this row.
     * @param int    $chunk_index The row index.
     * @param string $style       The display style.
     */
    do_action('hydir_after_row', $posts, $chunk_index, $style);

    echo '</div>';
  }

  /**
   * Fires after all columns output is complete.
   *
   * @since 1.2.0
   * @param array  $posts   Original array of post objects.
   * @param string $style   The display style.
   * @param int    $columns Number of columns.
   */
  do_action('hydir_after_columns', $posts, $style, $columns);
}
