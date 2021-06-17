<?php

/**
 * 
 */
wp_enqueue_style('progdir-css');

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<header class="entry-header has-text-align-center header-footer-group">
		<div class="entry-header-inner section-inner medium">
			<?php
			the_title('<h2>', '</h2>');

			$position = get_post_meta($id, 'position_title', true);

			?>
			<h3><?php echo $position; ?></h3>
		</div><!-- .entry-header-inner -->

	</header><!-- .entry-header -->
	<div class="post-inner">
		<div class="entry-content">
			<?php
			if (has_post_thumbnail()) {
				the_post_thumbnail('medium', array('class' => 'alignleft'));
			}

			do_action('progdir_single_before_content', $id);

			the_content();

			do_action('progdir_single_after_content', $id);
			?>

		</div><!-- .entry-content -->
	</div><!-- .post-inner -->
</article><!-- .post -->