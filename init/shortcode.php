<?php
if (! defined('ABSPATH')) exit;

/*
* Register Shortcode
*/

function hydir_shortcode($atts) {
  // Always enqueue core styles
  wp_enqueue_style('hydir-css');

  $args = shortcode_atts(
    array(
      'tax'     => "role",
      'term'    => NULL,    // Can be slug or name
      'show'    => "all",   // all, current, past
      'style'   => "list",  // default list, or any other type added by a plugin
      'columns' => "1",
      'headers' => "1",     // Show headers 1 = yes, 0 = no
      'content' => "excerpt", // full, excerpt, or none
      'excerpt_length' => "20", // Words to show in excerpt
    ),
    $atts
  );

  /**
   * Filter shortcode default arguments.
   *
   * @since 1.2.0
   * @param array $args The shortcode arguments after merging with defaults.
   * @param array $atts The raw shortcode attributes passed by the user.
   */
  $args = apply_filters('hydir_shortcode_defaults', $args, $atts);

  // Validate input
  $tax = sanitize_text_field($args['tax']);
  $term = sanitize_text_field($args['term']);
  $show = sanitize_text_field($args['show']);
  $style = sanitize_text_field($args['style']);
  $columns = absint($args['columns']) ?: 1;
  $headers = in_array($args['headers'], ["0", "1"], true) ? $args['headers'] : "1";
  $content = in_array($args['content'], ["full", "excerpt", "none"], true) ? $args['content'] : "excerpt";
  $excerpt_length = absint($args['excerpt_length']) ?: 20;

  // Enqueue card styles if using card layout
  if ($style === 'card') {
    wp_enqueue_style('list-card-css');
  }

  /**
   * Fires before shortcode styles are enqueued.
   * Use this hook to enqueue additional styles based on the style parameter.
   *
   * @since 1.2.0
   * @param string $style The display style (list, card, text, etc.).
   */
  do_action('hydir_shortcode_enqueue_styles', $style);

  /**
   * Filter the validated shortcode parameters before display.
   *
   * @since 1.2.0
   * @param array $params Array of validated parameters.
   */
  $params = apply_filters('hydir_shortcode_params', compact(
    'tax',
    'term',
    'show',
    'style',
    'columns',
    'headers',
    'content',
    'excerpt_length'
  ));

  // Extract filtered params
  extract($params);

  return hydir_display($tax, $term, $columns, $show, $style, $headers, $content, $excerpt_length);
}


/**
 * Shows all entries for a single term of a given taxonomy
 *
 * @param [string] $tax Taxonomy to display
 * @param [string] $term Name of term (not slug)
 * @param [int] $columns Number of columns
 * @param [string] $show Show all, current or alumni
 * @param [string] $style Display style (list, card, etc)
 * @param [string] $headers Show headers (0 or 1)
 * @param [string] $content Content display mode (full, excerpt, or none)
 * @param [int] $excerpt_length Words to show in excerpt
 * @return void
 */
function hydir_display($tax, $term, $columns, $show, $style, $headers, $content = "excerpt", $excerpt_length = 20) {
  $posts_array = hydir_get_posts_for_tax($tax, $term);

  /**
   * Filter the posts array before display.
   *
   * @since 1.2.0
   * @param array  $posts_array Array of posts grouped by term.
   * @param string $tax         The taxonomy being displayed.
   * @param string $term        The specific term (or null for all).
   * @param string $show        Show filter (all, current, past).
   */
  $posts_array = apply_filters('hydir_display_posts', $posts_array, $tax, $term, $show);

  if ($posts_array) {
    return hydir_shortcode_meat($posts_array, $columns, $term, $show, $style, $headers, $content, $excerpt_length);
  } else {
    /**
     * Filter the error message when no entries are found.
     *
     * @since 1.2.0
     * @param string $message The error message.
     * @param string $tax     The taxonomy that was queried.
     * @param string $term    The term that was queried.
     */
    return apply_filters(
      'hydir_no_entries_message',
      __('Hydrogen Directory Error: Term(s) not found or there are no associated posts', 'hydrogen-directory'),
      $tax,
      $term
    );
  }
}


/**
 * Displays entries grouped in columns
 *
 * @param array $posts_array Array of WP post objects
 * @param int $columns
 * @param string $term
 * @param string $show
 * @param string $style
 * @param string $headers
 * @param string $content
 * @param int $excerpt_length
 * @return void
 */
function hydir_shortcode_meat($posts_array, $columns, $term, $show, $style, $headers, $content = "excerpt", $excerpt_length = 20) {
  ob_start();

  /**
   * Fires before the directory output begins.
   *
   * @since 1.2.0
   * @param array  $posts_array Array of posts grouped by term.
   * @param string $style       The display style.
   */
  do_action('hydir_before_directory', $posts_array, $style);

  foreach ($posts_array as $term => $term_posts) {
    /**
     * Filter the CSS classes for the directory group wrapper.
     *
     * @since 1.2.0
     * @param string $classes Space-separated CSS classes.
     * @param string $term    The term name.
     * @param string $style   The display style.
     */
    $group_classes = apply_filters(
      'hydir_group_classes',
      'hydir-group group-' . esc_html(sanitize_title($term)) . ' hydir-group-' . esc_html($style),
      $term,
      $style
    );

    echo "<div class='" . esc_attr($group_classes) . "' >";

    /**
     * Fires at the start of each term group, before the header.
     *
     * @since 1.2.0
     * @param string $term       The term name.
     * @param array  $term_posts Array of posts in this term.
     * @param string $style      The display style.
     */
    do_action('hydir_before_group', $term, $term_posts, $style);

    do_action('hydir_shortcode_meat', $term, $term_posts, $show, $columns, $style, $headers, $content, $excerpt_length);

    /**
     * Fires at the end of each term group, after the entries.
     *
     * @since 1.2.0
     * @param string $term       The term name.
     * @param array  $term_posts Array of posts in this term.
     * @param string $style      The display style.
     */
    do_action('hydir_after_group', $term, $term_posts, $style);

    echo "</div> <!-- group -->";
  }

  /**
   * Fires after the directory output ends.
   *
   * @since 1.2.0
   * @param array  $posts_array Array of posts grouped by term.
   * @param string $style       The display style.
   */
  do_action('hydir_after_directory', $posts_array, $style);

  return ob_get_clean();
}



function hydir_shortcode_basic($term, $term_posts, $show, $columns, $style, $headers, $content = "excerpt", $excerpt_length = 20) {
  if ($headers) {
    /**
     * Filter the group header HTML.
     *
     * @since 1.2.0
     * @param string $header     The header HTML.
     * @param string $term       The term name.
     * @param array  $term_posts The posts in this group.
     */
    $header_html = apply_filters(
      'hydir_group_header',
      '<h2>' . esc_html($term) . '</h2>',
      $term,
      $term_posts
    );
    echo $header_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
  }

  hydir_column_fill($term_posts, $columns, $style, $content, $excerpt_length);
}
add_filter('hydir_shortcode_meat', 'hydir_shortcode_basic', 10, 8);
