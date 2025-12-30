<?php
if (! defined('ABSPATH')) exit;

/**
 * Template: Single Entry Content
 * 
 * Displays the full content for a single directory entry.
 * Override by copying to your theme's /templates/ folder.
 * 
 * Available hooks:
 * - hydir_single_before_content
 * - hydir_single_after_content
 * - hydir_single_before_header
 * - hydir_single_after_header
 * - hydir_single_before_title
 * - hydir_single_after_title
 * - hydir_single_before_thumbnail
 * - hydir_single_after_thumbnail
 * 
 * Available filters:
 * - hydir_single_thumbnail_size (default: 'medium')
 * - hydir_single_thumbnail_class (default: 'alignleft hydir-single-img')
 * - hydir_single_title (the title text)
 * - hydir_single_position (the position text)
 * - hydir_single_entry_classes (entry wrapper classes)
 * - hydir_single_show_thumbnail (default: true)
 */

wp_enqueue_style('hydir-css');

$hydir_post_id = get_the_ID();
$hydir_position = get_post_meta($hydir_post_id, 'position_title', true);

/**
 * Filter the position title on single entry.
 *
 * @since 1.2.0
 * @param string $position The position title.
 * @param int    $id       The post ID.
 */
$hydir_position = apply_filters('hydir_single_position', $hydir_position, $hydir_post_id);

$hydir_thumb_size = apply_filters('hydir_single_thumbnail_size', 'medium');
$hydir_thumb_class = apply_filters('hydir_single_thumbnail_class', 'alignleft hydir-single-img');

/**
 * Filter whether to show the thumbnail on single entry.
 *
 * @since 1.2.0
 * @param bool $show Whether to show thumbnail.
 * @param int  $id   The post ID.
 */
$hydir_show_thumbnail = apply_filters('hydir_single_show_thumbnail', true, $hydir_post_id);

/**
 * Filter the CSS classes for the single entry wrapper.
 *
 * @since 1.2.0
 * @param string $classes Space-separated CSS classes.
 * @param int    $id      The post ID.
 */
$entry_classes = apply_filters('hydir_single_entry_classes', 'hydir-single-entry', $hydir_post_id);
?>

<article <?php post_class($entry_classes); ?> id="post-<?php the_ID(); ?>" itemscope itemtype="https://schema.org/Person">

  <?php
  /**
   * Fires before the single entry header.
   *
   * @since 1.2.0
   * @param int $id The post ID.
   */
  do_action('hydir_single_before_header', $hydir_post_id);
  ?>

  <header class="entry-header hydir-entry-header">
    <div class="entry-header-inner">
      <?php
      /**
       * Fires before the single entry title.
       *
       * @since 1.2.0
       * @param int $id The post ID.
       */
      do_action('hydir_single_before_title', $hydir_post_id);

      /**
       * Filter the single entry title.
       *
       * @since 1.2.0
       * @param string $title The entry title.
       * @param int    $id    The post ID.
       */
      $hydir_title = apply_filters('hydir_single_title', get_the_title(), $hydir_post_id);
      ?>
      <h1 class="entry-title" itemprop="name"><?php echo esc_html($hydir_title); ?></h1>
      <?php
      /**
       * Fires after the single entry title.
       *
       * @since 1.2.0
       * @param int $id The post ID.
       */
      do_action('hydir_single_after_title', $hydir_post_id);
      ?>

      <?php if (!empty($hydir_position)) : ?>
        <p class="hydir-single-position" itemprop="jobTitle">
          <?php echo esc_html($hydir_position); ?>
        </p>
      <?php endif; ?>
    </div>
  </header>

  <?php
  /**
   * Fires after the single entry header.
   *
   * @since 1.2.0
   * @param int $id The post ID.
   */
  do_action('hydir_single_after_header', $hydir_post_id);
  ?>

  <div class="post-inner hydir-post-inner">
    <div class="entry-content hydir-entry-content" itemprop="description">

      <?php if ($hydir_show_thumbnail && has_post_thumbnail()) : ?>
        <?php
        /**
         * Fires before the single entry thumbnail.
         *
         * @since 1.2.0
         * @param int $id The post ID.
         */
        do_action('hydir_single_before_thumbnail', $hydir_post_id);
        ?>
        <figure class="hydir-single-figure">
          <?php the_post_thumbnail($hydir_thumb_size, array(
            'class' => $hydir_thumb_class,
            'itemprop' => 'image'
          )); ?>
        </figure>
        <?php
        /**
         * Fires after the single entry thumbnail.
         *
         * @since 1.2.0
         * @param int $id The post ID.
         */
        do_action('hydir_single_after_thumbnail', $hydir_post_id);
        ?>
      <?php endif; ?>

      <?php do_action('hydir_single_before_content', $hydir_post_id); ?>

      <?php the_content(); ?>

      <?php do_action('hydir_single_after_content', $hydir_post_id); ?>

    </div>
  </div>

</article>