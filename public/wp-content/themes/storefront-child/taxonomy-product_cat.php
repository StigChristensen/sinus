<?php
/**
 * product cat equals Product TYPE in the frontend
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     9.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

get_header(); ?>

<script type="text/javascript" src="<?php echo site_url() . '/wp-content/themes/storefront-child/js/grid.js'; ?>"></script>

<?php
global $post;
$args = array( 'taxonomy' => 'product_cat');
$terms = wp_get_post_terms($post->ID,'product_cat', $args);

$args = array( 'taxonomy' => 'product_tag');
$brands = wp_get_post_terms($post->ID,'product_tag', $args);

$q = get_queried_object();
$template_type = "type";

if ( $q->parent === 0 ) {
  $header = $q->name;
  $post_cat = $q->slug;
  $parent_term = $q->name;
  $num_posts = 36;
} else {
  $t = get_term($q->parent);
  $parent_term = $t->name;
  $sub_cat = $q->name;
  $post_cat = $q->slug;
  $header = $parent_term . " - " . $sub_cat;
  $num_posts = -1;
}

?>

<div class="product-template wrapper">
  <div class="product-header">
    <div class="product-headline">
      <h1><?php echo $header; ?></h1>
    </div>

    <div class="template-description">
      <span class="desc"><?php echo $q->description; ?></span>
    </div>
  </div>

  <div class="filters-wrap">
    <?php
      // Get product filtering template
      get_template_part( 'content', 'filtering-headphones' );
    ?>
</div>

      <div class="template type products-container" data-templatetype="<?php echo $template_type; ?>" data-category="<?php echo $parent_term; ?>" data-subcat="<?php echo $sub_cat; ?>">
          <div class="product-list-grid">
            <div class="template page products">
              <ul class="template products">
            <?php $args = array( 'post_type' => 'product', 'posts_per_page' => $num_posts, 'product_cat' => $post_cat );
                  $loop = new WP_Query( $args );
                  while ( $loop->have_posts() ) : $loop->the_post(); ?>

                    <?php wc_get_template_part( 'content', 'single-product-grid' ); ?>

                  <?php endwhile; ?>
              </ul>
            </div>
          </div>
      </div>
</div>
<?php get_footer(); ?>
