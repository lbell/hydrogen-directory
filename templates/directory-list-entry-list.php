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
 * - hydir_list_before_title
 * - hydir_list_after_title
 * - hydir_list_before_image
 * - hydir_list_after_image
 * 
 * Available filters:
 * - hydir_list_content (full content)
 * - hydir_list_show_link (default: true)
 * - hydir_list_show_content (default: true)
 * - hydir_list_full_content (default: false)
 * - hydir_list_excerpt_length (default: 20)
 * - hydir_list_button_text (default: 'More')
 * - hydir_list_entry_classes (entry wrapper classes)
 * - hydir_list_title (the title HTML)
 * - hydir_list_position (the position HTML)
 * - hydir_list_permalink (the entry URL)
 */

wp_enqueue_style('list-card-css');

$id = $post->ID;
$hydir_entry_permalink = get_permalink($id);

/**
 * Filter the permalink for a list entry.
 *
 * @since 1.2.0
 * @param string $permalink The entry permalink.
 * @param int    $id        The post ID.
 */
$hydir_entry_permalink = apply_filters('hydir_list_permalink', $hydir_entry_permalink, $id);

$hydir_pos = get_post_meta($id, 'position_title', true);
$hydir_show_link = apply_filters('hydir_list_show_link', true);
$hydir_show_content = apply_filters('hydir_list_show_content', true);
$hydir_full_content = apply_filters('hydir_list_full_content', false);
$hydir_excerpt_length = apply_filters('hydir_list_excerpt_length', apply_filters('hydir_excerpt_length', 20));
$hydir_button_text = apply_filters('hydir_list_button_text', __('More', 'hydrogen-directory'));

/**
 * Filter the CSS classes for the list entry wrapper.
 *
 * @since 1.2.0
 * @param string $classes Space-separated CSS classes.
 * @param int    $id      The post ID.
 */
$entry_classes = apply_filters('hydir_list_entry_classes', 'hydir-list-entry hydir-entry', $id);
?>

<article class="hydir-list-entry-container" itemscope itemtype="https://schema.org/Person">
  <hr />
  <div class="<?php echo esc_attr($entry_classes); ?>">

    <div class="hydir-list-img">
      <?php
      /**
       * Fires before the list entry image.
       *
       * @since 1.2.0
       * @param int $id The post ID.
       */
      do_action('hydir_list_before_image', $id);
      ?>
      <a href="<?php echo esc_url($hydir_entry_permalink); ?>" aria-hidden="true" tabindex="-1">
        <?php echo wp_kses_post(hydir_thumb($id, "hydir-medium-300")); ?>
      </a>
      <?php
      /**
       * Fires after the list entry image.
       *
       * @since 1.2.0
       * @param int $id The post ID.
       */
      do_action('hydir_list_after_image', $id);
      ?>
    </div>

    <div class="hydir-list-content">
      <div class="hydir-list-header">
        <?php
        /**
         * Fires before the list entry title.
         *
         * @since 1.2.0
         * @param int $id The post ID.
         */
        do_action('hydir_list_before_title', $id);

        /**
         * Filter the position title display.
         *
         * @since 1.2.0
         * @param string $position The position title.
         * @param int    $id       The post ID.
         */
        $hydir_pos = apply_filters('hydir_list_position', $hydir_pos, $id);
        ?>
        <h4 class="name">
          <?php if ($hydir_show_link) : ?>
            <a href="<?php echo esc_url($hydir_entry_permalink); ?>" itemprop="url">
              <span itemprop="name"><?php echo esc_html(apply_filters('hydir_list_title', get_the_title($id), $id)); ?></span>
            </a>
          <?php else : ?>
            <span itemprop="name"><?php echo esc_html(apply_filters('hydir_list_title', get_the_title($id), $id)); ?></span>
          <?php endif; ?>

          <?php if (!empty($hydir_pos)) : ?>
            <span class="hydir-position-separator"> — </span>
            <span class="hydir-position" itemprop="jobTitle"><?php echo esc_html($hydir_pos); ?></span>
          <?php endif; ?>
        </h4>
        <?php
        /**
         * Fires after the list entry title.
         *
         * @since 1.2.0
         * @param int $id The post ID.
         */
        do_action('hydir_list_after_title', $id);
        ?>
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
        <?php
        /**
         * Fires before the list entry footer/button.
         *
         * @since 1.2.0
         * @param int $id The post ID.
         */
        do_action('hydir_list_before_footer', $id);
        ?>
        <div class="hydir-list-footer">
          <a href="<?php echo esc_url($hydir_entry_permalink); ?>" class="hydir-list-more-button">
            <?php echo esc_html($hydir_button_text); ?>
          </a>
        </div>
        <?php
        /**
         * Fires after the list entry footer/button.
         *
         * @since 1.2.0
         * @param int $id The post ID.
         */
        do_action('hydir_list_after_footer', $id);
        ?>
      <?php endif; ?>
    </div>

  </div>
</article>