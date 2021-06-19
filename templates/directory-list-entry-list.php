<?php

/**
 * Template part 
 */

$id = $post->ID;
$entry_permalink = get_permalink($id);
$pos = get_post_meta($id, 'position_title', true);
$position = $pos ? " — $pos" : "";

?>

<!-- <div class="profile-container-parent"> -->
<div class='hydir-list-entry-container'>
	<hr />
	<div class='hydir-list-entry hydir-entry'>
		<div class='hydir-list-img'>
			<?php echo hydir_thumb($id, "hydir-medium-300"); ?>
		</div>
		<div class="hydir-list-content">
			<h4 class="name">

				<?php echo get_the_title($id) . esc_html($position) ?>

			</h4>

			<?php
			do_action('hydir_list_before_content', $id);

			echo apply_filters('hydir_list_content', get_the_content(null, false, $post));

			do_action('hydir_list_after_content', $id);
			?>
		</div>
	</div>
</div>