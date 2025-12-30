<?php
if (! defined('ABSPATH')) exit;

/**
 * Template: Text Entry (Minimal)
 * 
 * Displays a single directory entry as a simple text line.
 * Perfect for compact lists or quick references.
 * Override by copying to your theme's /templates/ folder.
 * 
 * Available hooks:
 * - hydir_text_before_entry
 * - hydir_text_after_entry
 * - hydir_text_before_name
 * - hydir_text_after_name
 * - hydir_text_before_content
 * - hydir_text_after_content
 * 
 * Available filters:
 * - hydir_text_show_link (default: true)
 * - hydir_text_show_position (default: true)
 * - hydir_text_show_content (default: false)
 * - hydir_text_full_content (default: false)
 * - hydir_text_excerpt_length (default: 20)
 * - hydir_text_bullet (default: '•')
 * - hydir_text_entry_classes (entry wrapper classes)
 * - hydir_text_title (the title text)
 * - hydir_text_position (the position text)
 * - hydir_text_permalink (the entry URL)
 * - hydir_text_separator (default: ' — ')
 * - hydir_text_content (the content text)
 */

$id = $post->ID;
$hydir_entry_permalink = get_permalink($id);

/**
 * Filter the permalink for a text entry.
 *
 * @since 1.2.0
 * @param string $permalink The entry permalink.
 * @param int    $id        The post ID.
 */
$hydir_entry_permalink = apply_filters('hydir_text_permalink', $hydir_entry_permalink, $id);

$hydir_pos = get_post_meta($id, 'position_title', true);

/**
 * Filter the position title display.
 *
 * @since 1.2.0
 * @param string $position The position title.
 * @param int    $id       The post ID.
 */
$hydir_pos = apply_filters('hydir_text_position', $hydir_pos, $id);

$hydir_show_link = apply_filters('hydir_text_show_link', true);
$hydir_show_position = apply_filters('hydir_text_show_position', true);
$hydir_bullet = apply_filters('hydir_text_bullet', '•');

// Content display options (follows same conventions as list/card templates)
$hydir_content_mode = apply_filters('hydir_content_mode', 'none'); // Default to none for text style
$hydir_show_content = apply_filters('hydir_text_show_content', $hydir_content_mode !== 'none');
$hydir_full_content = apply_filters('hydir_text_full_content', $hydir_content_mode === 'full');
$hydir_excerpt_length = apply_filters('hydir_text_excerpt_length', apply_filters('hydir_excerpt_length', 20));

/**
 * Filter the separator between name and position.
 *
 * @since 1.2.0
 * @param string $separator The separator string.
 */
$hydir_separator = apply_filters('hydir_text_separator', ' — ');

/**
 * Filter the CSS classes for the text entry wrapper.
 *
 * @since 1.2.0
 * @param string $classes Space-separated CSS classes.
 * @param int    $id      The post ID.
 */
$entry_classes = apply_filters('hydir_text_entry_classes', 'hydir-text-entry hydir-entry', $id);

/**
 * Filter the title text.
 *
 * @since 1.2.0
 * @param string $title The entry title.
 * @param int    $id    The post ID.
 */
$hydir_title = apply_filters('hydir_text_title', get_the_title($id), $id);
?>

<div class="hydir-text-entry-container" itemscope itemtype="https://schema.org/Person">
  <?php
  /**
   * Fires before the text entry.
   *
   * @since 1.2.0
   * @param int $id The post ID.
   */
  do_action('hydir_text_before_entry', $id);
  ?>
  <div class="<?php echo esc_attr($entry_classes); ?>">
    <div class="hydir-text-content">
      <p>
        <span class="hydir-bullet" aria-hidden="true"><?php echo esc_html($hydir_bullet); ?></span>

        <?php
        /**
         * Fires before the text entry name.
         *
         * @since 1.2.0
         * @param int $id The post ID.
         */
        do_action('hydir_text_before_name', $id);
        ?>

        <span itemprop="name"><?php echo esc_html($hydir_title); ?></span>

        <?php
        /**
         * Fires after the text entry name.
         *
         * @since 1.2.0
         * @param int $id The post ID.
         */
        do_action('hydir_text_after_name', $id);
        ?>

        <?php if ($hydir_show_position && !empty($hydir_pos)) : ?>
          <span class="hydir-position-separator"><?php echo esc_html($hydir_separator); ?></span>
          <span class="hydir-position" itemprop="jobTitle"><?php echo esc_html($hydir_pos); ?></span>
        <?php endif; ?>
      </p>

      <?php
      /**
       * Fires before the text entry content.
       *
       * @since 1.2.0
       * @param int $id The post ID.
       */
      do_action('hydir_text_before_content', $id);
      ?>

      <?php if ($hydir_show_content) : ?>
        <div class="hydir-text-description <?php echo $hydir_full_content ? 'hydir-text-content-full' : ''; ?>" itemprop="description">
          <?php
          if ($hydir_full_content) {
            /**
             * Filter the full content text.
             *
             * @since 1.2.0
             * @param string $content The full content.
             * @param int    $id      The post ID.
             */
            echo wp_kses_post(apply_filters('hydir_text_content', get_the_content(null, false, $post), $id));
          } else {
            /**
             * Filter the excerpt content text.
             *
             * @since 1.2.0
             * @param string $excerpt The excerpt content.
             * @param int    $id      The post ID.
             */
            $excerpt = wp_trim_words(get_the_excerpt($post), $hydir_excerpt_length);
            $excerpt .= ' <a href="' . esc_url($hydir_entry_permalink) . '">more...</a>';
            echo wp_kses_post(apply_filters('hydir_text_content', $excerpt, $id));
          }
          ?>
        </div>
      <?php endif; ?>

      <?php
      /**
       * Fires after the text entry content.
       *
       * @since 1.2.0
       * @param int $id The post ID.
       */
      do_action('hydir_text_after_content', $id);
      ?>

    </div>
  </div>
  <?php
  /**
   * Fires after the text entry.
   *
   * @since 1.2.0
   * @param int $id The post ID.
   */
  do_action('hydir_text_after_entry', $id);
  ?>
</div>