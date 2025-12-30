<?php
if (! defined('ABSPATH')) exit;

/**
 * Template: Card Entry
 * 
 * Displays a single directory entry in card format.
 * Override by copying to your theme's /templates/ folder.
 * 
 * Available hooks:
 * - hydir_card_before_content
 * - hydir_card_after_content
 * 
 * Available filters:
 * - hydir_card_content (excerpt content)
 * - hydir_card_excerpt_length (default: 25)
 * - hydir_card_button_text (default: 'View Profile')
 */

wp_enqueue_style('list-card-css');

$id = $post->ID;
$hydir_entry_permalink = get_permalink($id);
$hydir_position = get_post_meta($id, 'position_title', true);
$hydir_excerpt_length = apply_filters('hydir_card_excerpt_length', 25);
$hydir_button_text = apply_filters('hydir_card_button_text', __('View Profile', 'hydrogen-directory'));
?>

<article class="hydir-card-entry-container">
  <div class="hydir-card-entry hydir-entry" itemscope itemtype="https://schema.org/Person">
    
    <?php echo wp_kses_post(hydir_thumb($id)); ?>
    
    <div class="hydir-card-content">
      <h4 class="name" itemprop="name">
        <a href="<?php echo esc_url($hydir_entry_permalink); ?>" itemprop="url">
          <?php echo esc_html(get_the_title($id)); ?>
        </a>
      </h4>
      
      <?php if (!empty($hydir_position)) : ?>
        <h5 itemprop="jobTitle"><?php echo esc_html($hydir_position); ?></h5>
      <?php endif; ?>
      
      <?php do_action('hydir_card_before_content', $id); ?>
      
      <p itemprop="description">
        <?php echo wp_kses_post(apply_filters('hydir_card_content', wp_trim_words(get_the_excerpt($post), $hydir_excerpt_length))); ?>
      </p>
      
      <?php do_action('hydir_card_after_content', $id); ?>
      
      <div class="buttons">
        <a href="<?php echo esc_url($hydir_entry_permalink); ?>">
          <button type="button"><?php echo esc_html($hydir_button_text); ?></button>
        </a>
      </div>
    </div>
    
  </div>
</article>