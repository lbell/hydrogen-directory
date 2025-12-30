<?php
if (! defined('ABSPATH')) exit;

/**
 * Template: List Entry
 * 
 * Displays a single directory entry in horizontal list format.
 * Override by copying to your theme's /templates/ folder.
 * 
 * Available hooks:
 * - hydir_list_before_content
 * - hydir_list_after_content
 * 
 * Available filters:
 * - hydir_list_content (full content)
 * - hydir_list_show_link (default: true)
 */

$id = $post->ID;
$hydir_entry_permalink = get_permalink($id);
$hydir_pos = get_post_meta($id, 'position_title', true);
$hydir_show_link = apply_filters('hydir_list_show_link', true);
?>

<article class="hydir-list-entry-container" itemscope itemtype="https://schema.org/Person">
  <hr />
  <div class="hydir-list-entry hydir-entry">
    
    <div class="hydir-list-img">
      <a href="<?php echo esc_url($hydir_entry_permalink); ?>" aria-hidden="true" tabindex="-1">
        <?php echo wp_kses_post(hydir_thumb($id, "hydir-medium-300")); ?>
      </a>
    </div>
    
    <div class="hydir-list-content">
      <h4 class="name">
        <?php if ($hydir_show_link) : ?>
          <a href="<?php echo esc_url($hydir_entry_permalink); ?>" itemprop="url">
            <span itemprop="name"><?php echo esc_html(get_the_title($id)); ?></span>
          </a>
        <?php else : ?>
          <span itemprop="name"><?php echo esc_html(get_the_title($id)); ?></span>
        <?php endif; ?>
        
        <?php if (!empty($hydir_pos)) : ?>
          <span class="hydir-position-separator"> — </span>
          <span class="hydir-position" itemprop="jobTitle"><?php echo esc_html($hydir_pos); ?></span>
        <?php endif; ?>
      </h4>
      
      <?php do_action('hydir_list_before_content', $id); ?>
      
      <div class="hydir-list-description" itemprop="description">
        <?php echo wp_kses_post(apply_filters('hydir_list_content', get_the_content(null, false, $post))); ?>
      </div>
      
      <?php do_action('hydir_list_after_content', $id); ?>
    </div>
    
  </div>
</article>