<?php

/**
 * Gets an array of all post-type taxonomies and associated terms in default order
 *
 * @param string $in_type name of post type
 * @param boolean $hide_empty whether to hide terms with no associated posts
 * 
 * @return array
 */
function get_all_terms($in_type = NULL, $hide_empty = FALSE) {

	// $taxonomies = get_object_taxonomies( $in_type ?? 'directory' ); // PHP 7 and above
	$taxonomies = get_object_taxonomies(isset($in_type) ? $in_type : 'directory');
	$taxonomy_terms = array();

	foreach ($taxonomies as $tax) {
		$terms = get_terms(
			array(
				'taxonomy' => $tax,
				'hide_empty' => $hide_empty,
			)
		);

		$has_terms = is_array($terms) && $terms;

		if ($has_terms) {
			$taxonomy_terms[$tax] = $terms;
		}
	}
	return $taxonomy_terms;
}


/**
 * Get all terms for a given taxonomy
 *
 * @param string $tax
 * @return array of terms
 */
function get_tax_terms($tax) {
	$terms = get_terms(array(
		'taxonomy' => $tax,
		'parent'   => 0
	));

	return $terms;
}


/**
 * Gets all posts for all terms of a given taxonomy in a nested array:
 * Array(term(post,post),term(post,post))
 *
 * @param string $tax
 * @return array
 */
function get_posts_for_tax($tax, $term = NULL) {

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
			$terms = isset($term) ? [get_term_by('slug', $term, $tax)] : get_tax_terms($tax);
		}
	} else {
		// Otherwise, get array of all terms for $tax
		$terms = get_tax_terms($tax);
	}

	foreach ($terms as $term) {

		if (!is_object($term)) {
			// echo "Error: Term not found";
			break;
		}

		$posts = get_posts(array(
			'post_type' => 'directory',
			'tax_query' => array(
				array(
					'taxonomy' => $tax,
					'field' => 'slug',
					'terms' => $term->slug,
				)
			),
			'orderby' => 'title', // TODO: Make this selectable in shortcode
			'order'   => 'ASC',
			'numberposts' => -1
		));

		if (!empty($posts)) {
			$term_name = $term->name;
			$results[$term_name] = NULL;
			foreach ($posts as $post) {
				$results[$term_name][] = $post;
			}
		}
	}
	return $results;
}
