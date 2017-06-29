<?php  get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php

				$apps = get_posts(array('post_type' => 'app-post-type'));
				if ($apps)
				{
					foreach ($apps as $eachApp)
					{
						$meta = get_post_meta($eachApp->ID, 'app_meta', true);
						Timber::render('templates/App.Excerpt.twig', ($meta) ? $meta : array());
					}
				}
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer(); ?>
