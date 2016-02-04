<?php
/**
 * Template Name: Social Page
 */
get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <div class="spinner hidden">
      <div class="circle"></div>
      <div class="circle1"></div>
    </div>

      <div class="info-container" id="user-info"></div>
      <div class="feed-container" id="user-feed"></div>

      <script src="<?php echo get_stylesheet_directory_uri() . '/socialApp/socialApp.js'; ?>"></script>

    </main>
  </div>

<?php get_footer(); ?>
