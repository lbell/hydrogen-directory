<?php

/**
 * Template part 
 */

wp_enqueue_style('list-card-css');


$id = $post->ID;
$entry_permalink = get_permalink($id);
// $content = get_the_content(null, false, $post);
?>

<!-- <div class="profile-container-parent"> -->
<div class="hydir-card-entry-container">
	<div class="hydir-card-entry hydir-entry">
		<?php echo hydir_thumb($id); ?>
		<div class="hydir-card-content">
			<h4 class="name">
				<a href="<?php echo esc_url($entry_permalink); ?>">
					<?php echo get_the_title($id); ?>
				</a>
			</h4>
			<?php
			$position = get_post_meta($id, 'position_title', true); // DEBUG

			if (!empty($position)) {
				echo "<h5>" . esc_html($position) . "</h5>";
			}
			do_action('hydir_card_before_content', $id);

			echo apply_filters('hydir_card_content', wp_trim_words(get_the_excerpt($post), 30));

			do_action('hydir_card_after_content', $id);

			?>
			<div class="buttons">
				<a href="<?php echo esc_url($entry_permalink); ?>"><button>Profile</button></a>
			</div>
		</div>
	</div>
</div>