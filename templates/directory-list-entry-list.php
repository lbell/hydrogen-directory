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
 * - hydir_list_show_content (default: true)
 * - hydir_list_full_content (default: false)
 * - hydir_list_excerpt_length (default: 20)
 * - hydir_list_button_text (default: 'More')
 */

wp_enqueue_style('list-card-css');

$id = $post->ID;
$hydir_entry_permalink = get_permalink($id);
$hydir_pos = get_post_meta($id, 'position_title', true);
$hydir_show_link = apply_filters('hydir_list_show_link', true);
$hydir_show_content = apply_filters('hydir_list_show_content', true);
$hydir_full_content = apply_filters('hydir_list_full_content', false);
$hydir_excerpt_length = apply_filters('hydir_list_excerpt_length', apply_filters('hydir_excerpt_length', 20));
$hydir_button_text = apply_filters('hydir_list_button_text', __('More', 'hydrogen-directory'));
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
      <div class="hydir-list-header">
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
      </div>

      <?php do_action('hydir_list_before_content', $id); ?>

      <?php if ($hydir_show_content) : ?>
        <div class="hydir-list-description <?php echo $hydir_full_content ? 'hydir-list-content-full' : ''; ?>" itemprop="description">
          <?php
          if ($hydir_full_content) {
            echo wp_kses_post(apply_filters('hydir_list_content', get_the_content(null, false, $post)));
          } else {
            echo wp_kses_post(apply_filters('hydir_list_content', wp_trim_words(get_the_excerpt($post), $hydir_excerpt_length)));
          }
          ?>
        </div>
      <?php endif; ?>

      <?php do_action('hydir_list_after_content', $id); ?>

      <?php if (!$hydir_full_content) : ?>
        <div class="hydir-list-footer">
          <a href="<?php echo esc_url($hydir_entry_permalink); ?>" class="hydir-list-more-button">
            <?php echo esc_html($hydir_button_text); ?>
          </a>
        </div>
      <?php endif; ?>
    </div>

  </div>
</article>