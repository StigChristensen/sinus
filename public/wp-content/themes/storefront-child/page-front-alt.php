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


<div class="frontpage top content">

<div class="top left"></div>
<div class="top right"></div>

  <div class="frontpage banner-container">

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


<?php // List of top selling products ?>
<div class="products top frontpage">
  <?php
  $top = get_field('top_sellers');

  if ( $top ): ?>
    <ul class="products list">
    <h2>Mest solgte:</h2>
      <?php foreach ($top as $post ) {
        setup_postdata($post); ?>
        <?php wc_get_template_part('content', 'widget-product'); ?>
  <?php }
    wp_reset_postdata(); ?>
    </ul>
  <?php endif; ?>
</div>




<div class="products-container">
  <div class="menu-left-button">
    <span>SORTER</span>
  </div>

  <div class="menu-left">
    <div class="sort-links">
      <h3>Sorter</h3>
      <p class="price-sorter"><i class="fa fa-search-plus"></i>Pris <i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></p>
      <h3>PÅ LAGER:</h3>
      <input type='checkbox' class='instock' name='instock' value='checked' id="instock" checked /><label for="instock"><i class="fa fa-check-square"></i></label>
      <input type='checkbox' class='outofstock' name='outofstock' value='checked' id="outofstock" checked /><label for="outofstock"><i class="fa fa-minus-square"></i></label>
    </div>
    <div class="categories">
      <h3>Kategorier</h3>
      <span>I denne liste:</span>
    </div>
    <div class="brands">
      <h3>Brands</h3>
      <span>I denne liste:</span>
    </div>

    <div class="close-left">
      <i class="fa fa-angle-left"></i>
    </div>
  </div>

  <div class="product-list-grid">

  <?php // reg product list ?>


  </div>
</div>


<div class="product-modal hidden">
  <div class="modal-close-btn"><i class="fa fa-times-circle-o"></i></div>
  <div class="modal-scroll-indicator">
    <i class="fa fa-angle-down first"></i>
    <i class="fa fa-angle-down second"></i>
  </div>
  <div class="modal-content"></div>
</div>
<div class="product-modal-overlay hidden"></div>

<?php get_footer(); ?>
