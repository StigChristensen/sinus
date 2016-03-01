<?php
/**
 * Template Name: Front Page Filters
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
      <div class="front-page wrapper">
        <div class="front-video-container">
          <div class="spinner"><div class="circle"></div><div class="circle1"></div></div>
          <video id="frontpage-video" src="<?php echo get_stylesheet_directory_uri() . '/img/video/sinus_intro_1.mp4'; ?>"></video>
        </div>

        <div class="moving-content">

        <div class="bg-container" data-id="1">
          <img class="bg-1" src="<?php echo get_stylesheet_directory_uri() . '/img/bg/bg1.png'; ?>" alt="">
        </div>

          <div class="filters first">
            <ul class="front-filter">
            <?php
            $args = array(
              'orderby'      => 'name',
              'order'        => 'ASC',
              'hide_empty'   => 1
            );

            $tags = get_terms('product_tag', $args);
            foreach( $tags as $tag ) {
            ?>
              <li class="cat-item"><a href="<?php echo get_term_link($tag->slug, 'product_tag'); ?>"><?php echo $tag->name; ?></a></li>
            <?php } ?>
            </ul>
          </div>

          <div class="filters second">
            <ul class="front-filter">
            <?php
              $args = array(
                'show_option_all'    => '',
                'orderby'            => 'name',
                'order'              => 'ASC',
                'style'              => 'list',
                'show_count'         => 0,
                'hide_empty'         => 1,
                'use_desc_for_title' => 1,
                'child_of'           => 0,
                'hierarchical'       => 1,
                'title_li'           => __( '' ),
                'show_option_none'   => __( '' ),
                'number'             => null,
                'echo'               => 1,
                'depth'              => 0,
                'current_category'   => 0,
                'pad_counts'         => 0,
                'taxonomy'           => 'product_cat',
                'walker'             => null
              );
              wp_list_categories( $args );
            ?>
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
        </div>

      </div>
    </main>
  </div>

<?php get_footer(); ?>
