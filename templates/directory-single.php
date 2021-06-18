<?php
/* Template Name: Archive Page Custom */
get_header(); ?>

<div id="primary" class="site-content">
	<div id="hydir-single" role="main">

		<?php
		while (have_posts()) :
			the_post();

			include hydir_get_template_part('directory-single-content');

			edit_post_link();

			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()) :
				comments_template();
			endif;

			// Previous/next post navigation.
			the_post_navigation(array(
				'next_text' => '<span class="meta-nav" aria-hidden="true">' . __('Next', 'hydir') . '</span> ' .
					'<span class="screen-reader-text">' . __('Next post:', 'hydir') . '</span> ' .
					'<span class="post-title">%title</span>',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __('Previous', 'hydir') . '</span> ' .
					'<span class="screen-reader-text">' . __('Previous post:', 'hydir') . '</span> ' .
					'<span class="post-title">%title</span>',
			));

		// End the loop.
		endwhile;
		?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php // get_sidebar(); 
?>
<?php get_footer(); ?>