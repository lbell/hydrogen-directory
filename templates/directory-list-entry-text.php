<?php
if (! defined('ABSPATH')) exit;

/**
 * Template: Text Entry (Minimal)
 * 
 * Displays a single directory entry as a simple text line.
 * Perfect for compact lists or quick references.
 * Override by copying to your theme's /templates/ folder.
 * 
 * Available filters:
 * - hydir_text_show_link (default: true)
 * - hydir_text_show_position (default: true)
 * - hydir_text_bullet (default: '•')
 */

$id = $post->ID;
$hydir_entry_permalink = get_permalink($id);
$hydir_pos = get_post_meta($id, 'position_title', true);

$hydir_show_link = apply_filters('hydir_text_show_link', true);
$hydir_show_position = apply_filters('hydir_text_show_position', true);
$hydir_bullet = apply_filters('hydir_text_bullet', '•');
?>

<div class="hydir-text-entry-container" itemscope itemtype="https://schema.org/Person">
  <div class="hydir-text-entry hydir-entry">
    <div class="hydir-text-content">
      <p>
        <span class="hydir-bullet" aria-hidden="true"><?php echo esc_html($hydir_bullet); ?></span>

        <?php if ($hydir_show_link) : ?>
          <a href="<?php echo esc_url($hydir_entry_permalink); ?>" itemprop="url">
            <span itemprop="name"><?php echo esc_html(get_the_title($id)); ?></span>
          </a>
        <?php else : ?>
          <span itemprop="name"><?php echo esc_html(get_the_title($id)); ?></span>
        <?php endif; ?>

        <?php if ($hydir_show_position && !empty($hydir_pos)) : ?>
          <span class="hydir-position-separator"> — </span>
          <span class="hydir-position" itemprop="jobTitle"><?php echo esc_html($hydir_pos); ?></span>
        <?php endif; ?>
      </p>
    </div>
  </div>
</div>