<?php

/**
 * Template part 
 */

$id = $post->ID;
$pos = get_post_meta($id, 'position_title', true);
$position = $pos ? " — $pos" : "";

?>

<!-- <div class="profile-container-parent"> -->
<div class='progdir-text-entry-container'>
	<div class='progdir-text-entry progdir-entry'>
		<div class="progdir-text-content">
			<p>
				• <?php echo get_the_title($id) . $position ?>
			</p>
		</div>
	</div>
</div>