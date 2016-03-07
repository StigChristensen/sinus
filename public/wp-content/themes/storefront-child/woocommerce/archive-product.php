<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

get_header();

if ( $_GET && $_GET['brand'] ) {
  $brand = $_GET['brand'];
} else {
  $brand = '';
}

if ( $_GET && $_GET['side'] ) {
  $page = $_GET['side'];
} else {
  $page = '';
}

global $post;
$args = array( 'taxonomy' => 'product_cat',);
$terms = wp_get_post_terms($post->ID,'product_cat', $args);

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

$args = array(
  'post_type' => 'product',
  'posts_per_page' => 24,
  'fields' => 'id',
  'paged' => $paged,
  'tax_query' => array(
    array(
      'taxonomy' => 'product_cat',
      'field'    => 'slug',
      'terms'    => $terms[0]->slug,
    ),
  ),
);

$postslist = new WP_Query( $args );
$totalpages = $postslist->max_num_pages;
?>
  <div class="menu-left">
    <div class="sort-links">
      <h3>Sorter</h3>
    </div>
    <div class="categories">
      <h3>Kategorier</h3>
      <span>I denne liste:</span>
    </div>
    <div class="brands">
      <h3>Brands</h3>
      <span>I denne liste:</span>
    </div>
  </div>

  <div class="products-container" data-cat="<?php echo $terms[0]->slug; ?>" data-tag="<?php echo $brand; ?>" data-page="<?php echo $page; ?>" data-maxpages="<?php echo $totalpages; ?>">
      <div class="spinner"><div class="circle"></div><div class="circle1"></div></div>
      <div class="product-list-grid"></div>
  </div>

<?php get_footer( 'shop' ); ?>
