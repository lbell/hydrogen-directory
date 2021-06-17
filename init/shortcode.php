<?php
/*
* Register Shortcode
*/

function progdir_shortcode($atts) {
	wp_enqueue_style('progdir-css');

	extract(
		shortcode_atts(
			array(
				'tax'     => "role",
				'term'    => NULL,      // Can be slug or name
				'show'    => "all",   // all, current, past
				'style'   => "list",  // default list, or any other type added by a plugin
				'columns' => "3",     // TODO: Create a "fill" to maximize columns based on viewport
				'headers' => "1",     // Show headers 1 = yes, 0 = no
			),
			$atts
		)
	);

	// Validate input
	$tax = sanitize_text_field($tax);
	$term = sanitize_text_field($term);
	$show = sanitize_text_field($show);
	$style = sanitize_text_field($style);
	$columns = is_int((int)$columns) ? $columns : 1;
	$headers = in_array($headers, ["0", "1"], true) ? $headers : "1";

	// if (!empty($term)) {
	// 	return progdir_display_single($tax, $term, $columns, $show, $style, $headers);
	// }
	// return progdir_display_by_tax($tax, $columns, $show, $style, $headers);

	return progdir_display($tax, $term, $columns, $show, $style, $headers);
}


/**
 * Shows all entries for a given taxonomy, divided by terms (default)
 *
 * @param string $tax Taxonomy to display
 * @param int $columns Number of columns
 * @return void
 */
// function progdir_display_by_tax($tax, $columns, $show, $style, $headers) {
// 	$posts_array = get_posts_for_tax($tax);
// 	return progdir_shortcode_meat($posts_array, $columns, FALSE, $show, $style, $headers);
// }


/**
 * Shows all entries for a single term of a given taxonomy
 *
 * @param [string] $tax Taxonomy to display
 * @param [string] $term Name of term (not slug)
 * @param [int] $columns Number of columns
 * @param [string] $show Show all, current or alumni
 * @return void
 */
function progdir_display($tax, $term, $columns, $show, $style, $headers) {
	$posts_array = get_posts_for_tax($tax, $term);

	if ($posts_array) {
		return progdir_shortcode_meat($posts_array, $columns, $term, $show, $style, $headers);
	} else {
		return __('Program Directory Error: Term(s) not found or has no associated posts', 'progdir');
	}
}


/**
 * Displays entries grouped in columns
 *
 * @param array $posts_array Array of WP post objects
 * @param int $columns
 * @return void
 */
function progdir_shortcode_meat($posts_array, $columns, $term, $show, $style, $headers) {
	ob_start();

	foreach ($posts_array as $term => $term_posts) {
		echo "<div class='progdir-group group-" . sanitize_title($term) . " progdir-group-" . $style . "' >";

		apply_filters('progdir_shortcode_meat', $term, $term_posts, $show, $columns, $style, $headers);

		echo "</div> <!-- group -->";
	}
	return ob_get_clean();
}



function progdir_shortcode_basic($term, $term_posts, $show, $columns, $style, $headers) {
	if ($headers) {
		echo "<h2>" . $term . "</h2>";
	}

	column_fill($term_posts, $columns, $style);
}
add_filter('progdir_shortcode_meat', 'progdir_shortcode_basic', 10, 6);
