<?php

/**
 * Creates wp-block-columns of a given number, and backfills with empty columns
 *
 * @param array $posts
 * @param int $columns
 * @return void echos instead of returns to be captured by ob_start();
 */
function hydir_column_fill($posts, $columns, $style) {

	$array_chunks = array_chunk($posts, $columns);
	$template_name = "directory-list-entry-" . $style;
	$template_exists = hydir_get_template_part($template_name);

	foreach ($array_chunks as $posts) {
		echo '<div class="wp-block-columns hydir-columns hydir-columns-' . esc_attr($style) . '">';
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
			echo '<div class="wp-block-column">';
			echo '</div>';
		}
		echo '</div>';
	}
}
