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
 * 
 * Available filters:
 * - hydir_single_thumbnail_size (default: 'medium')
 * - hydir_single_thumbnail_class (default: 'alignleft hydir-single-img')
 */

wp_enqueue_style('hydir-css');

$hydir_post_id = get_the_ID();
$hydir_position = get_post_meta($hydir_post_id, 'position_title', true);
$hydir_thumb_size = apply_filters('hydir_single_thumbnail_size', 'medium');
$hydir_thumb_class = apply_filters('hydir_single_thumbnail_class', 'alignleft hydir-single-img');
?>

<article <?php post_class('hydir-single-entry'); ?> id="post-<?php the_ID(); ?>" itemscope itemtype="https://schema.org/Person">

  <header class="entry-header hydir-entry-header">
    <div class="entry-header-inner">
      <?php the_title('<h1 class="entry-title" itemprop="name">', '</h1>'); ?>

      <?php if (!empty($hydir_position)) : ?>
        <p class="hydir-single-position" itemprop="jobTitle">
          <?php echo esc_html($hydir_position); ?>
        </p>
      <?php endif; ?>
    </div>
  </header>

  <div class="post-inner hydir-post-inner">
    <div class="entry-content hydir-entry-content" itemprop="description">

      <?php if (has_post_thumbnail()) : ?>
        <figure class="hydir-single-figure">
          <?php the_post_thumbnail($hydir_thumb_size, array(
            'class' => $hydir_thumb_class,
            'itemprop' => 'image'
          )); ?>
        </figure>
      <?php endif; ?>

      <?php do_action('hydir_single_before_content', $hydir_post_id); ?>

      <?php the_content(); ?>

      <?php do_action('hydir_single_after_content', $hydir_post_id); ?>

    </div>
  </div>

</article>