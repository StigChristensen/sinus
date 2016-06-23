<?php
/**
 * Template Name: Handelsvilkår
 */
get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <div class="vilkaar-container">
      <div class="content-bg">
        <img src="<?php echo get_stylesheet_directory_uri() . '/img/bg/bg5.png'; ?>" alt="Content background image" />
      </div>

      <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

          // Include the page content template.
          get_template_part( 'content', 'page' );

        // End the loop.
          endwhile;
        ?>

      </div>
    </main>
  </div>

<?php get_footer(); ?>
