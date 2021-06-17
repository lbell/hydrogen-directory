<?php

/**
 * Creates wp-block-columns of a given number, and backfills with empty columns
 *
 * @param array $posts
 * @param int $columns
 * @return void echos instead of returns to be captured by ob_start();
 */
function column_fill($posts, $columns, $style) {
	console_log($columns); // DEBUG

	$array_chunks = array_chunk($posts, $columns);
	$template_name = "directory-list-entry-" . $style;
	$template_exists = progdir_get_template_part($template_name);
	console_log($template_exists); // DEBUG


	foreach ($array_chunks as $posts) {
		echo '<div class="wp-block-columns progdir-columns">';
		foreach ($posts as $post) {
			echo '<div class="wp-block-column progdir-column">';

			if (is_null($template_exists)) {
				include progdir_get_template_part('directory-list-entry-list');
			} else {
				include progdir_get_template_part($template_name);
			}
			echo '</div>';
		}
		for ($i = 0; $i < ($columns - count($posts)); $i++) {
			console_log($i); // DEBUG

			echo '<div class="wp-block-column">';
			echo '</div>';
		}
		echo '</div>';
	}
}
