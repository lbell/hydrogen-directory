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
 */

get_header(); 
?>

<div id="primary" class="site-content hydir-site-content">
  <main id="hydir-single" class="hydir-single-main" role="main">

    <?php
    while (have_posts()) :
      the_post();

      include hydir_get_template_part('directory-single-content');

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
</div>

<?php 
get_footer();