<?php
if (! defined('ABSPATH')) exit;

/**
 * Get all terms for a given taxonomy
 *
 * @param string $tax
 * @return array of terms
 */
function hydir_get_tax_terms($tax) {
  /**
   * Filter the arguments for getting taxonomy terms.
   *
   * @since 1.2.0
   * @param array  $args The arguments for get_terms().
   * @param string $tax  The taxonomy slug.
   */
  $term_args = apply_filters('hydir_get_terms_args', array(
    'taxonomy' => $tax,
    'parent'   => 0
  ), $tax);

  $terms = get_terms($term_args);

  /**
   * Filter the terms returned for a taxonomy.
   *
   * @since 1.2.0
   * @param array  $terms Array of term objects.
   * @param string $tax   The taxonomy slug.
   */
  return apply_filters('hydir_tax_terms', $terms, $tax);
}


/**
 * Gets all posts for all terms of a given taxonomy in a nested array:
 * Array(term(post,post),term(post,post))
 *
 * @param string $tax
 * @return array
 */
function hydir_get_posts_for_tax($tax, $term = NULL) {

  // Default to role if taxonomy doesn't exist (addon disabled)
  // if (!taxonomy_exists($tax)) {
  // 	$tax = "role";
  // 	$term = NULL;
  // }
  $terms = array();
  $results = array();


  if (!empty($term)) {
    // Get array of terms for tax, or if set, get the single term
    $terms = [get_term_by('name', $term, $tax)];

    if ($terms == [FALSE]) {
      $terms = isset($term) ? [get_term_by('slug', $term, $tax)] : hydir_get_tax_terms($tax);
    }
  } else {
    // Otherwise, get array of all terms for $tax
    $terms = hydir_get_tax_terms($tax);
  }

  foreach ($terms as $term) {

    if (!is_object($term)) {
      break;
    }

    $posts = get_posts(array(
      'post_type' => 'hy_directory',
      'tax_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
        array(
          'taxonomy' => $tax,
          'field' => 'slug',
          'terms' => $term->slug,
        )
      ),
      'orderby' => apply_filters('hydir_posts_orderby', 'title', $tax, $term), // TODO: Make this selectable in shortcode
      'order'   => apply_filters('hydir_posts_order', 'ASC', $tax, $term),
      'numberposts' => apply_filters('hydir_posts_limit', -1, $tax, $term)
    ));

    if (!empty($posts)) {
      $term_name = $term->name;
      $results[$term_name] = NULL;
      foreach ($posts as $post) {
        $results[$term_name][] = $post;
      }
    }
  }

  /**
   * Filter the posts array before returning.
   *
   * @since 1.2.0
   * @param array       $results The posts grouped by term name.
   * @param string      $tax     The taxonomy slug.
   * @param string|null $term    The specific term requested (or null).
   */
  return apply_filters('hydir_posts_for_tax', $results, $tax, $term);
}
