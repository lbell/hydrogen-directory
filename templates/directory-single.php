<?php
if (! defined('ABSPATH')) exit;

/**
 * Template: Single Entry Page
 * 
 * Full page wrapper for single directory entries.
 * Override by copying to your theme's /templates/ folder
 * or creating a directory-single.php in your theme root.
 * 
 * Displays with theme's header and footer for proper styling integration.
 * Compatible with both classic themes and block themes (FSE).
 */

// Check if this is a block theme (no header.php)
$is_block_theme = wp_is_block_theme();

if ($is_block_theme) {
?>
  <!DOCTYPE html>
  <html <?php language_attributes(); ?>>

  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div class="wp-site-blocks">
      <?php block_template_part('header'); ?>
    <?php
  } else {
    get_header();
  }
    ?>

    <div id="primary" class="site-content hydir-site-content">
      <?php
      /**
       * Fires before the single entry main content area.
       *
       * @since 1.2.0
       */
      do_action('hydir_single_before_main');
      ?>
      <main id="hydir-single" class="hydir-single-main" role="main">

        <?php
        while (have_posts()) :
          the_post();

          /**
           * Fires before the single entry template is included.
           *
           * @since 1.2.0
           * @param int $post_id The current post ID.
           */
          do_action('hydir_single_before_template', get_the_ID());

          include hydir_get_template_part('directory-single-content');

          /**
           * Fires after the single entry template is included.
           *
           * @since 1.2.0
           * @param int $post_id The current post ID.
           */
          do_action('hydir_single_after_template', get_the_ID());

          edit_post_link(
            __('Edit Entry', 'hydrogen-directory'),
            '<p class="hydir-edit-link">',
            '</p>'
          );

          // If comments are open or we have at least one comment, load the comment template.
          if (comments_open() || get_comments_number()) :
            comments_template();
          endif;

          // Previous/next post navigation.
          the_post_navigation(array(
            'prev_text' => '<span class="nav-subtitle">' . __('Previous', 'hydrogen-directory') . '</span> <span class="nav-title">%title</span>',
            'next_text' => '<span class="nav-subtitle">' . __('Next', 'hydrogen-directory') . '</span> <span class="nav-title">%title</span>',
          ));

        endwhile;
        ?>

      </main>
      <?php
      /**
       * Fires after the single entry main content area.
       *
       * @since 1.2.0
       */
      do_action('hydir_single_after_main');
      ?>
    </div>

    <?php
    if ($is_block_theme) {
      block_template_part('footer');
    ?>
    </div><!-- .wp-site-blocks -->
    <?php wp_footer(); ?>
  </body>

  </html>
<?php
    } else {
      get_footer();
    }
