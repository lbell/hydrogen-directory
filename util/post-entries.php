<?php

/**
 * Get all terms for a given taxonomy
 *
 * @param string $tax
 * @return array of terms
 */
function hydir_get_tax_terms($tax) {
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
