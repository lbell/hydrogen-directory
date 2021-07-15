<?php
/*
* Register Shortcode
*/

function hydir_shortcode($atts) {
	wp_enqueue_style('hydir-css');

	$args = shortcode_atts(
		array(
			'tax'     => "role",
			'term'    => NULL,    // Can be slug or name
			'show'    => "all",   // all, current, past
			'style'   => "list",  // default list, or any other type added by a plugin
			'columns' => "1",
			'headers' => "1",     // Show headers 1 = yes, 0 = no
		),
		$atts
	);

	// Validate input
	$tax = sanitize_text_field($args['tax']);
	$term = sanitize_text_field($args['term']);
	$show = sanitize_text_field($args['show']);
	$style = sanitize_text_field($args['style']);
	$columns = is_int((int)$args['columns']) ? $args['columns'] : 1;
	$headers = in_array($args['headers'], ["0", "1"], true) ? $args['headers'] : "1";

	return hydir_display($tax, $term, $columns, $show, $style, $headers);
}


/**
 * Shows all entries for a single term of a given taxonomy
 *
 * @param [string] $tax Taxonomy to display
 * @param [string] $term Name of term (not slug)
 * @param [int] $columns Number of columns
 * @param [string] $show Show all, current or alumni
 * @return void
 */
function hydir_display($tax, $term, $columns, $show, $style, $headers) {
	$posts_array = hydir_get_posts_for_tax($tax, $term);

	if ($posts_array) {
		return hydir_shortcode_meat($posts_array, $columns, $term, $show, $style, $headers);
	} else {
		return __('Hydrogen Directory Error: Term(s) not found or there are no associated posts', 'hydir');
	}
}


/**
 * Displays entries grouped in columns
 *
 * @param array $posts_array Array of WP post objects
 * @param int $columns
 * @return void
 */
function hydir_shortcode_meat($posts_array, $columns, $term, $show, $style, $headers) {
	ob_start();

	foreach ($posts_array as $term => $term_posts) {
		echo "<div class='hydir-group group-" . sanitize_title($term) . " hydir-group-" . esc_html($style) . "' >";

		apply_filters('hydir_shortcode_meat', $term, $term_posts, $show, $columns, $style, $headers);

		echo "</div> <!-- group -->";
	}
	return ob_get_clean();
}



function hydir_shortcode_basic($term, $term_posts, $show, $columns, $style, $headers) {
	if ($headers) {
		echo "<h2>" . esc_html($term) . "</h2>";
	}

	hydir_column_fill($term_posts, $columns, $style);
}
add_filter('hydir_shortcode_meat', 'hydir_shortcode_basic', 10, 6);
