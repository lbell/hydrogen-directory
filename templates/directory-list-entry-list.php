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
<div class='progdir-list-entry-container'>
	<div class='progdir-list-entry progdir-entry'>
		<div class='progdir-list-img'>
			<?php echo progdir_thumb($id, "progdir-medium-300"); ?>
		</div>
		<div class="progdir-list-content">
			<h4 class="name">

				<?php echo get_the_title($id) . esc_html($position) ?>

			</h4>

			<?php
			do_action('progdir_list_before_content', $id);

			// echo apply_filters('progdir_list_content', wp_trim_words(get_the_excerpt($post), 25));
			echo apply_filters('progdir_list_content', get_the_content(null, false, $post));

			do_action('progdir_list_after_content', $id);
			?>
		</div>
	</div>
</div>