<?php

/**
 * Block Registration and REST API for Hydrogen Directory
 *
 * @package hydrogen-directory
 */

if (! defined('ABSPATH')) exit;

/**
 * Register the Hydrogen Directory Gutenberg block
 */
function hydir_register_block() {
  // Only register if Gutenberg is available
  if (!function_exists('register_block_type')) {
    return;
  }

  register_block_type(HYDIR_DIR . 'blocks/directory');
}
add_action('init', 'hydir_register_block');


/**
 * Register REST API endpoint for block preview
 */
function hydir_register_rest_routes() {
  // Preview endpoint
  register_rest_route('hydrogen-directory/v1', '/preview', array(
    'methods'             => 'GET',
    'callback'            => 'hydir_rest_preview',
    'permission_callback' => function () {
      return current_user_can('edit_posts');
    },
    'args'                => array(
      'taxonomy' => array(
        'type'              => 'string',
        'default'           => 'role',
        'sanitize_callback' => 'sanitize_text_field',
      ),
      'terms' => array(
        'type'              => 'string',
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
      ),
      'style' => array(
        'type'              => 'string',
        'default'           => 'list',
        'sanitize_callback' => 'sanitize_text_field',
      ),
      'columns' => array(
        'type'              => 'integer',
        'default'           => 1,
        'sanitize_callback' => 'absint',
      ),
      'headers' => array(
        'type'              => 'string',
        'default'           => '1',
        'sanitize_callback' => 'sanitize_text_field',
      ),
      'content' => array(
        'type'              => 'string',
        'default'           => 'excerpt',
        'sanitize_callback' => 'sanitize_text_field',
      ),
      'excerpt_length' => array(
        'type'              => 'integer',
        'default'           => 20,
        'sanitize_callback' => 'absint',
      ),
    ),
  ));

  // Taxonomies endpoint - get taxonomies associated with hy_directory
  register_rest_route('hydrogen-directory/v1', '/taxonomies', array(
    'methods'             => 'GET',
    'callback'            => 'hydir_rest_taxonomies',
    'permission_callback' => function () {
      return current_user_can('edit_posts');
    },
  ));

  // Terms endpoint - get terms for a specific taxonomy
  register_rest_route('hydrogen-directory/v1', '/terms/(?P<taxonomy>[a-zA-Z0-9_-]+)', array(
    'methods'             => 'GET',
    'callback'            => 'hydir_rest_terms',
    'permission_callback' => function () {
      return current_user_can('edit_posts');
    },
    'args'                => array(
      'taxonomy' => array(
        'type'              => 'string',
        'required'          => true,
        'sanitize_callback' => 'sanitize_text_field',
      ),
    ),
  ));
}
add_action('rest_api_init', 'hydir_register_rest_routes');


/**
 * REST API callback for block preview
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function hydir_rest_preview($request) {
  $taxonomy       = $request->get_param('taxonomy');
  $terms          = $request->get_param('terms');
  $style          = $request->get_param('style');
  $columns        = $request->get_param('columns');
  $headers        = $request->get_param('headers');
  $content        = $request->get_param('content');
  $excerpt_length = $request->get_param('excerpt_length');

  // Validate content parameter
  $content = in_array($content, ['full', 'excerpt', 'none'], true) ? $content : 'excerpt';

  /**
   * Filter the REST API preview parameters.
   *
   * @since 1.2.0
   * @param array           $params  Array of preview parameters.
   * @param WP_REST_Request $request The request object.
   */
  $params = apply_filters('hydir_rest_preview_params', compact(
    'taxonomy', 'terms', 'style', 'columns', 'headers', 'content', 'excerpt_length'
  ), $request);

  // Extract filtered params
  extract($params);

  /**
   * Fires before the REST API preview is generated.
   *
   * @since 1.2.0
   * @param array           $params  The preview parameters.
   * @param WP_REST_Request $request The request object.
   */
  do_action('hydir_rest_preview_before', $params, $request);

  // Handle multiple terms - generate output for each
  $html = '';
  if (!empty($terms)) {
    $term_array = array_filter(array_map('trim', explode(',', $terms)));
    foreach ($term_array as $term) {
      $html .= hydir_display($taxonomy, $term, $columns, 'all', $style, $headers, $content, $excerpt_length);
    }
  } else {
    // No specific terms - show all
    $html = hydir_display($taxonomy, null, $columns, 'all', $style, $headers, $content, $excerpt_length);
  }

  // If no content, provide a helpful message
  if (empty($html) || strpos($html, 'Error') !== false) {
    /**
     * Filter the empty preview message.
     *
     * @since 1.2.0
     * @param string $message The empty state message HTML.
     */
    $html = apply_filters('hydir_rest_preview_empty_message', 
      '<div class="hydir-preview-empty">' .
      '<p>' . __('No directory entries found.', 'hydrogen-directory') . '</p>' .
      '<p><small>' . __('Add entries to the Directory post type and assign them to roles to see them here.', 'hydrogen-directory') . '</small></p>' .
      '</div>'
    );
  }

  /**
   * Filter the REST API preview HTML response.
   *
   * @since 1.2.0
   * @param string          $html    The preview HTML.
   * @param array           $params  The preview parameters.
   * @param WP_REST_Request $request The request object.
   */
  $html = apply_filters('hydir_rest_preview_html', $html, $params, $request);

  return new WP_REST_Response(array(
    'html' => $html
  ), 200);
}


/**
 * REST API callback for taxonomies list
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function hydir_rest_taxonomies($request) {
  // Get taxonomies associated with the hy_directory post type
  $taxonomies = get_object_taxonomies('hy_directory', 'objects');

  $result = array();
  foreach ($taxonomies as $tax_slug => $tax_obj) {
    $result[] = array(
      'slug'  => $tax_slug,
      'name'  => $tax_obj->labels->singular_name,
      'label' => $tax_obj->labels->name,
    );
  }

  // If no taxonomies found, at least return 'role' as default
  if (empty($result)) {
    $result[] = array(
      'slug'  => 'role',
      'name'  => __('Role', 'hydrogen-directory'),
      'label' => __('Roles', 'hydrogen-directory'),
    );
  }

  /**
   * Filter the REST API taxonomies response.
   *
   * @since 1.2.0
   * @param array           $result  Array of taxonomy data.
   * @param WP_REST_Request $request The request object.
   */
  $result = apply_filters('hydir_rest_taxonomies', $result, $request);

  return new WP_REST_Response($result, 200);
}


/**
 * REST API callback for terms of a taxonomy
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function hydir_rest_terms($request) {
  $taxonomy = $request->get_param('taxonomy');

  // Verify taxonomy exists
  if (!taxonomy_exists($taxonomy)) {
    return new WP_REST_Response(array(), 200);
  }

  $terms = get_terms(array(
    'taxonomy'   => $taxonomy,
    'hide_empty' => false,
  ));

  if (is_wp_error($terms)) {
    return new WP_REST_Response(array(), 200);
  }

  $result = array();
  foreach ($terms as $term) {
    $result[] = array(
      'id'    => $term->term_id,
      'name'  => $term->name,
      'slug'  => $term->slug,
      'count' => $term->count,
    );
  }

  /**
   * Filter the REST API terms response.
   *
   * @since 1.2.0
   * @param array           $result   Array of term data.
   * @param string          $taxonomy The taxonomy slug.
   * @param WP_REST_Request $request  The request object.
   */
  $result = apply_filters('hydir_rest_terms', $result, $taxonomy, $request);

  return new WP_REST_Response($result, 200);
}


/**
 * Enqueue block editor assets
 */
function hydir_enqueue_block_editor_assets() {
  // Enqueue frontend styles in editor for accurate preview
  wp_enqueue_style('hydir-css');
  wp_enqueue_style('list-card-css');

  /**
   * Fires when block editor assets are enqueued.
   * Use this hook to enqueue additional editor styles or scripts.
   *
   * @since 1.2.0
   */
  do_action('hydir_enqueue_block_editor_assets');
}
add_action('enqueue_block_editor_assets', 'hydir_enqueue_block_editor_assets');
