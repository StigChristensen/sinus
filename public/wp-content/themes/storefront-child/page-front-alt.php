<?php
/**
 * Template Name: Front Alternate
 */

get_header(); ?>

<div class="scroll-indicator hidden">
  <i class="fa fa-angle-down first"></i>
  <i class="fa fa-angle-down second"></i>
</div>

<?php
global $post;
$args = array( 'taxonomy' => 'product_cat');
$terms = wp_get_post_terms($post->ID,'product_cat', $args);
?>


<div class="fp-wrap">

  <div class="front top content">
    <div class="bg-color"></div>

  <div class="top left animate">
    <h4>Sinus</h4><span> er Danmarks mest specialiserede forretning indenfor hovedtelefoner og transportabel lyd.
    Vi har i takt med den teknologiske udvikling nået et punkt hvor hovedparten af den musik vi hører i løbet af en dag, lyttes til igennem vores hovedtelefoner. Og vi mener at musikken i dit liv fortjener god lyd.<br><br>
Men hovedtelefoner er ikke bare den gode lyd til dit livs soundtrack. Hovedtelefoner er mode, hovedtelefoner er frihed fra omverdenens støj, hovedtelefoner er in-ear, on-ear, over-ear, med eller uden bluetooth og vigtigst af alt hovedtelefoner skal matche dig og dine behov – og det kan og vil vi hjælpe med.
    </span>
  </div>

  <div class="top center">
    <h4>Top 10</h4>
    <?php
      $top = get_field('top_sellers');

      if ( $top ): ?>
        <ul class="products list">
          <?php foreach ($top as $post ) {
            setup_postdata($post); ?>
            <?php wc_get_template_part('content', 'single-product-list'); ?>
      <?php }
         ?>
        </ul>
      <?php endif; ?>

  </div>

  <div class="top right">
    <h4>Nyheder</h4>
    <ul class="articles front">
      <?php $args = array( 'post_type' => 'article', 'posts_per_page' => 5, 'post_status' => 'publish' );
          $loop = new WP_Query( $args );
          while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <li class="article list animate">
              <a href="<?php the_permalink(); ?>">
              <?php
                $img = get_field('article_image');
                if ( $img ) {
              ?>
                <img src="<?php the_field('article_image'); ?>" alt="Sinus Copenhagen Sinus-Store - <?php the_title(); ?>">
              <?php } ?>
                <div class="article-title">
                  <span class="article"><?php the_title(); ?></span>
                </div>
              </a>
            </li>

    <?php endwhile; ?>
      </ul>
  </div>


</div>

    <div class="banner-container front">
    <?php $args = array( 'post_type' => 'banner', 'posts_per_page' => 2 );
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


  <div class="products-container frontpage">
    <div class="menu-left front">
      <!-- <div class="sort-links">
        <h3>Sorter</h3>
        <p class="price-sorter"><i class="fa fa-search-plus"></i>Pris <i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></p>
        <h3>PÅ LAGER:</h3>
        <input type='checkbox' class='instock' name='instock' value='checked' id="instock" checked /><label for="instock"><i class="fa fa-check-square"></i></label>
        <input type='checkbox' class='outofstock' name='outofstock' value='checked' id="outofstock" checked /><label for="outofstock"><i class="fa fa-minus-square"></i></label>
      </div> -->
      <div class="categories">
        <h3>Kategorier</h3>
          <ul class="front-filter">
            <?php
            $args = array(
              'orderby'      => 'name',
              'order'        => 'ASC',
              'hide_empty'   => 1
            );

            $cats = get_terms('product_cat', $args);
            foreach( $cats as $cat ) {
            ?>
              <li class="cat-item"><a href="<?php echo get_term_link($cat->slug, 'product_cat'); ?>"><?php echo $cat->name; ?></a></li>
            <?php } ?>
            </ul>
      </div>
      <div class="brands">
        <h3>Brands</h3>
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

      <div class="close-left">
        <i class="fa fa-angle-left"></i>
      </div>
    </div>

    <div class="product-list-grid front">

      <div class="page products front">
        <ul class="products front">
        <?php
            $query_args = array(
               'post_type' => 'product',
               'posts_per_page' => 30,
               'product_cat' => 'hovedtelefoner',
             );
            $loop = new WP_Query( $query_args );
            while ( $loop->have_posts() ) : $loop->the_post();
            wc_get_template_part('content', 'single-product-grid');
        ?>

        <?php endwhile; ?>
        </ul>

      </div>

      <a href="<?php echo site_url() . '/type/hovedtelefoner'; ?>" class="more products">Flere Produkter</a>

    </div>
  </div>

</div>

<?php get_footer(); ?>

<script src="<?php echo get_stylesheet_directory_uri() . '/js/fp.js'; ?>"></script>
