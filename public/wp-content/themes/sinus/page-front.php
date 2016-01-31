<?php
/**
 * Template Name: Front Page
 */

get_header(); ?>

	<div id="primary" class="content-area">
	<div class="bg"></div>
		<main id="main" class="site-main" role="main">
		<div class="logo">
		<img src="<?php echo get_template_directory_uri() . '/img/sinus_logo2.png'; ?>" alt=" Sinus Headphones company logo" />
		<h4>sinus-store.dk // headphones & audio</h4>
		</div>

			<?php while ( have_posts() ) : the_post(); ?>
				<div class="page-content">
					<?php the_content(); ?>
				</div>
			<?php endwhile; ?>
		</main>
	</div>

<?php get_footer(); ?>
