<?php
/**
 * Template Name: Front Page Filters
 */

get_header(); ?>

<div class="scroll-indicator hidden">
  <i class="fa fa-angle-down first"></i>
  <i class="fa fa-angle-down second"></i>
</div>

      <div class="front-page wrapper">

        <div class="moving-content">
          <div class="catch">
            <h3>The Soundtrack of your life <br>deserves good sound!</h3>
          </div>


          <div class="bg-container">
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
           <li class="cat-item">
                <a href="/type/hovedtelefoner/">Hovedtelefoner</a>
              </li>
              <li class="cat-item">
                <a href="/type/traadloese-hoejttalere/">Trådløse Højttalere</a>
              </li>
              <li class="cat-item">
                <a href="/type/tilbehoer/">Tilbehør</a>
              </li>
              <li class="cat-item">
                <a href="/type/preamps/">Preamps / Hovedtelefonforstærker</a>
              </li>
              <li class="cat-item">
                <a href="/type/dac/">DAC</a>
              </li>
              <li class="cat-item">
                <a href="/type/pladespillere/">Pladespillere</a>
              </li>
            </ul>
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
