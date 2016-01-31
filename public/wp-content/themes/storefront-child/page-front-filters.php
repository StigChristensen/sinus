<?php
/**
 * Template Name: Front Page Filters
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <div class="filters">
      <ul class="main-filters">
        <li class="filter">
          <a href="/type/headphones/street/"><img src="<?php echo get_stylesheet_directory_uri() . '/img/filters/Street.png'; ?>" alt="product category sinus-store headphones and audio street headphones streetwear"></a>
        </li>
        <li class="filter">
          <a href="/type/headphones/dj/"><img src="<?php echo get_stylesheet_directory_uri() . '/img/filters/DJ.png'; ?>" alt="product category sinus-store headphones and audio DJ dj headphones dj wear"></a>
        </li>
        <li class="filter">
          <a href="/type/headphones/gaming/"><img src="<?php echo get_stylesheet_directory_uri() . '/img/filters/Gaming.png'; ?>" alt="product category sinus-store headphones and audio gaming headphones gaming headwear"></a>
        </li>
        <li class="filter">
          <a href="/type/headphones/studie/"><img src="<?php echo get_stylesheet_directory_uri() . '/img/filters/Studio.png'; ?>" alt="product category sinus-store headphones and audio professional studio headphones"></a>
        </li>
        <li class="filter">
          <a href="/type/headphones/inear/"><img src="<?php echo get_stylesheet_directory_uri() . '/img/filters/IN-EAR.png'; ?>" alt="product category sinus-store headphones and audio in-ear headphones in ear streetwear"></a>
        </li>
        <li class="filter">
          <a href="/type/headphones/wireless-noise-cancelling/"><img src="<?php echo get_stylesheet_directory_uri() . '/img/filters/Wireless.png'; ?>" alt="product category sinus-store headphones and audio wireless headphones streetwear work hifi"></a>
        </li>
      </ul>
    </div>

    <div class="banner-container">

    <?php $args = array( 'post_type' => 'banner', 'posts_per_page' => 1 );
          $loop = new WP_Query( $args );
          while ( $loop->have_posts() ) : $loop->the_post(); ?>

          <div class="banner">
            <a href="<?php the_field('banner_link'); ?>" target="_parent">
              <img src="<?php the_field('banner_image'); ?>" alt="Sinus Store Headphones and Audio Front Page Banner"/>
            </a>
          </div>

    <?php endwhile; ?>

    </div>


    </main>
  </div>

<?php get_footer(); ?>
