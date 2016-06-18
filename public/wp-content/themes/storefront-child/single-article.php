<?php
/**
 * Template Name: Single Article
 */

get_header(); ?>

<div class="article container">

  <div class="article headline-wrap">
    <div class="article headline">
      <h1><?php the_title(); ?></h1>
    </div>
  </div>

    <div class="content-container">
      <?php the_field('article_content'); ?>
    </div>

</div>


<?php get_footer(); ?>
