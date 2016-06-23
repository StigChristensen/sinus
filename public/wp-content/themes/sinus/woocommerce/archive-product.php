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

global $post;
$args = array( 'taxonomy' => 'product_cat');
$terms = wp_get_post_terms($post->ID,'product_cat', $args);
?>

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

<div class="product-modal hidden">
  <div class="modal-close-btn"><i class="fa fa-times-circle-o"></i></div>
  <div class="modal-scroll-indicator">
    <i class="fa fa-angle-down first"></i>
    <i class="fa fa-angle-down second"></i>
  </div>
  <div class="modal-content"></div>
</div>
<div class="product-modal-overlay hidden"></div>

<div class="products-container" data-cat="<?php echo $terms[0]->slug; ?>">
    <div class="spinner"><div class="circle"></div><div class="circle1"></div></div>

    <div class="category-description">
      <div class="desc-esc"></div>
      <div class="desc-more"></div>
      <div class="more-btn"><p>Læs mere...</p></div>
    </div>

    <div class="product-list-grid">






    </div>
</div>

<?php get_footer( 'shop' ); ?>
