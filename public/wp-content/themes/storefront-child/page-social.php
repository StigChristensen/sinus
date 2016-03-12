<?php
/**
 * Template Name: Social Page
 */
get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <div class="social-header">
      <div class="content-bg">
        <img src="<?php echo get_stylesheet_directory_uri() . '/img/bg/bg6.png'; ?>" alt="Content background image" />
      </div>
      <div class="content-container">
        <h3>Find os på de sociale medier!</h3>
        <p>Besøg vores side på <a href="https://www.facebook.com/sinusstore/"><i class="fa fa-facebook"></i> FACEBOOK</a> <br>Eller se vores <a href="https://www.instagram.com/sinus_headphones/"><i class="fa fa-instagram"></i> INSTAGRAM</a> feed forneden. </p>
      </div>
    </div>


      <div class="info-container" id="user-info"></div>
      <div class="feed-container" id="user-feed"></div>

      <script src="<?php echo get_stylesheet_directory_uri() . '/socialApp/socialApp.js'; ?>"></script>

    </main>
  </div>

<?php get_footer(); ?>
