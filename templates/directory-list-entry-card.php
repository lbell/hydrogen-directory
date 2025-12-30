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
 * - hydir_card_before_title
 * - hydir_card_after_title
 * - hydir_card_before_image
 * - hydir_card_after_image
 * - hydir_card_before_footer
 * - hydir_card_after_footer
 * 
 * Available filters:
 * - hydir_card_show_content (default: true)
 * - hydir_card_full_content (default: false)
 * - hydir_card_excerpt_length (default: 25)
 * - hydir_card_button_text (default: 'View Profile')
 * - hydir_card_entry_classes (entry wrapper classes)
 * - hydir_card_title (the title text)
 * - hydir_card_position (the position text)
 * - hydir_card_permalink (the entry URL)
 */

wp_enqueue_style('list-card-css');

$id = $post->ID;
$hydir_entry_permalink = get_permalink($id);

/**
 * Filter the permalink for a card entry.
 *
 * @since 1.2.0
 * @param string $permalink The entry permalink.
 * @param int    $id        The post ID.
 */
$hydir_entry_permalink = apply_filters('hydir_card_permalink', $hydir_entry_permalink, $id);

$hydir_position = get_post_meta($id, 'position_title', true);

/**
 * Filter the position title display.
 *
 * @since 1.2.0
 * @param string $position The position title.
 * @param int    $id       The post ID.
 */
$hydir_position = apply_filters('hydir_card_position', $hydir_position, $id);

$hydir_show_content = apply_filters('hydir_card_show_content', true);
$hydir_full_content = apply_filters('hydir_card_full_content', false);
$hydir_excerpt_length = apply_filters('hydir_card_excerpt_length', apply_filters('hydir_excerpt_length', 25));
$hydir_button_text = apply_filters('hydir_card_button_text', __('View Profile', 'hydrogen-directory'));

/**
 * Filter the CSS classes for the card entry wrapper.
 *
 * @since 1.2.0
 * @param string $classes Space-separated CSS classes.
 * @param int    $id      The post ID.
 */
$entry_classes = apply_filters('hydir_card_entry_classes', 'hydir-card-entry hydir-entry' . ($hydir_full_content ? ' hydir-card-full-content' : ''), $id);
?>

<article class="hydir-card-entry-container">
  <div class="<?php echo esc_attr($entry_classes); ?>" itemscope itemtype="https://schema.org/Person">

    <?php
    /**
     * Fires before the card entry image.
     *
     * @since 1.2.0
     * @param int $id The post ID.
     */
    do_action('hydir_card_before_image', $id);

    echo wp_kses_post(hydir_thumb($id));

    /**
     * Fires after the card entry image.
     *
     * @since 1.2.0
     * @param int $id The post ID.
     */
    do_action('hydir_card_after_image', $id);
    ?>

    <div class="hydir-card-content">
      <?php
      /**
       * Fires before the card entry title.
       *
       * @since 1.2.0
       * @param int $id The post ID.
       */
      do_action('hydir_card_before_title', $id);
      ?>
      <h4 class="name" itemprop="name">
        <a href="<?php echo esc_url($hydir_entry_permalink); ?>" itemprop="url">
          <?php echo esc_html(apply_filters('hydir_card_title', get_the_title($id), $id)); ?>
        </a>
      </h4>

      <?php if (!empty($hydir_position)) : ?>
        <h5 itemprop="jobTitle"><?php echo esc_html($hydir_position); ?></h5>
      <?php endif; ?>
      <?php
      /**
       * Fires after the card entry title.
       *
       * @since 1.2.0
       * @param int $id The post ID.
       */
      do_action('hydir_card_after_title', $id);
      ?>

      <?php do_action('hydir_card_before_content', $id); ?>

      <?php if ($hydir_show_content) : ?>
        <p itemprop="description" class="<?php echo $hydir_full_content ? 'hydir-card-content-full' : ''; ?>">
          <?php
          if ($hydir_full_content) {
            echo wp_kses_post(apply_filters('hydir_card_content', get_the_content(null, false, $post)));
          } else {
            echo wp_kses_post(apply_filters('hydir_card_content', wp_trim_words(get_the_excerpt($post), $hydir_excerpt_length)));
          }
          ?>
        </p>
      <?php endif; ?>

      <?php do_action('hydir_card_after_content', $id); ?>

      <?php if (!$hydir_full_content) : ?>
        <?php
        /**
         * Fires before the card entry footer/button.
         *
         * @since 1.2.0
         * @param int $id The post ID.
         */
        do_action('hydir_card_before_footer', $id);
        ?>
        <div class="buttons">
          <a href="<?php echo esc_url($hydir_entry_permalink); ?>">
            <button type="button"><?php echo esc_html($hydir_button_text); ?></button>
          </a>
        </div>
        <?php
        /**
         * Fires after the card entry footer/button.
         *
         * @since 1.2.0
         * @param int $id The post ID.
         */
        do_action('hydir_card_after_footer', $id);
        ?>
      <?php endif; ?>
    </div>

  </div>
</article>