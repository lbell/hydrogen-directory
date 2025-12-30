<?php
if (! defined('ABSPATH')) exit;

/**
 * Template part 
 */

$id = $post->ID;
$hydir_pos = get_post_meta($id, 'position_title', true);
$hydir_position = $hydir_pos ? " — $hydir_pos" : "";

?>

<!-- <div class="profile-container-parent"> -->
<div class='hydir-text-entry-container'>
  <div class='hydir-text-entry hydir-entry'>
    <div class="hydir-text-content">
      <p>
        • <?php echo esc_html(get_the_title($id)) . esc_html($hydir_position) ?>
      </p>
    </div>
  </div>
</div>