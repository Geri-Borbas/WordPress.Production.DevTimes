<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php

			while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/post/content', 'compact' );
			endwhile;
		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
