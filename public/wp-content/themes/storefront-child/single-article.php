<?php
/**
 * Template Name: Single Article
 */

get_header(); ?>

<div class="om-os-container">

  <div class="headline"><h1><?php the_title(); ?></h1></div>

  <div class="page-element">
    <div class="content-bg">
      <img src="<?php echo get_stylesheet_directory_uri() . '/img/bg/bg4.png'; ?>" alt="Content background image" />
    </div>
    <div class="content-container">
    <div class="om-os-text">
    <?php the_field('article_content'); ?>
    </div>
  </div>


</div>


<?php get_footer(); ?>
