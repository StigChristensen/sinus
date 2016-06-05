<?php
/**
 * Template Name: Front Alternate
 */

get_header(); ?>

<div class="scroll-indicator hidden">
  <i class="fa fa-angle-down first"></i>
  <i class="fa fa-angle-down second"></i>
</div>

      <div class="">

        <div class="moving-content">

          <div class="bg-container">
            <img class="bg-1" src="<?php echo get_stylesheet_directory_uri() . '/img/bg/bg1.png'; ?>" alt="Sinus Store Copenhagen">
          </div>

          <div class="banner-container">

          <?php $args = array( 'post_type' => 'banner', 'posts_per_page' => -1 );
                $loop = new WP_Query( $args );
                while ( $loop->have_posts() ) : $loop->the_post();

                $should_show = get_field('showing');

                if ($should_show) { ?>

                <div class="banner">
                  <a href="<?php the_field('banner_link'); ?>" target="_parent">
                    <img src="<?php the_field('banner_image'); ?>" alt="Sinus Store Headphones and Audio Front Page Banner"/>
                  </a>
                </div>

          <?php } ?>

          <?php endwhile; ?>
          </div>




        </div>

      </div>

<?php get_footer(); ?>
