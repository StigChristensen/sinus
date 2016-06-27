<?php
/**
 * product tag equals BRAND
 *
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     9.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

get_header();

global $post;
$args = array( 'taxonomy' => 'product_tag');
$terms = wp_get_post_terms($post->ID,'product_tag', $args);
?>

<h1>Product Brand - <?php echo $terms[0]->slug; ?></h1>

<div class="products-container" data-brand="<?php echo $terms[0]->slug; ?>" data-template="type">
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
