<?php

/**
 * Callback function to convert category metabox to dropdown select
 *
 * @param object $post
 * @param object $box
 * @return void
 */
function hydir_dropdown_cat_callback($post, $box) {

	$defaults = array(
		'taxonomy' => 'category'
	);

	if (!isset($box['args']) || !is_array($box['args'])) {
		$args = array();
	} else {
		$args = $box['args'];
	}

	$args = wp_parse_args($args, $defaults);
	$taxonomy = $args['taxonomy'];

	$tax = get_taxonomy($taxonomy);
	$tax_edit_url = admin_url() . 'edit-tags.php?taxonomy=' . $tax->name . '&post_type=' . $post->post_type;

?>

	<div id="taxonomy-<?php echo esc_attr($taxonomy); ?>" class="taxonomy-field categorydiv">

		<?php
		$name = ($taxonomy == 'category') ? 'post_category' : 'tax_input[' . $taxonomy . ']';
		echo "<input type='hidden' name='" . esc_attr($name) . "[]' value='0' />";
		$term_obj = wp_get_object_terms($post->ID, $taxonomy); ?>


		<?php
		wp_dropdown_categories(
			array(
				'taxonomy'         => $taxonomy,
				'hide_empty'       => 0,
				'name'             => "{$name}[]",
				'selected'         => isset($term_obj[0]) ? $term_obj[0]->term_id : '',
				'orderby'          => 'name',
				'hierarchical'     => 1,
				'show_option_none' => ''
			)
		); ?>

	</div>
	<p>
		<a class="taxonomy-add-new" href="<?php echo esc_url($tax_edit_url) ?>">
			<?php printf(__('+ Add New %s', 'hydir'), $tax->labels->singular_name); ?>
		</a>

	</p>
<?php
}
