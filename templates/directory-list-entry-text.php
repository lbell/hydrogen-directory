<?php

/**
 * Template part 
 */

$id = $post->ID;
$pos = get_post_meta($id, 'position_title', true);
$position = $pos ? " — $pos" : "";

?>

<!-- <div class="profile-container-parent"> -->
<div class='hydir-text-entry-container'>
	<div class='hydir-text-entry hydir-entry'>
		<div class="hydir-text-content">
			<p>
				• <?php echo get_the_title($id) . esc_html($position) ?>
			</p>
		</div>
	</div>
</div>