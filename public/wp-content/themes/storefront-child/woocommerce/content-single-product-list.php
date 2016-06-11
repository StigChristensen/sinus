<?php
/**
 * The template for displaying product list entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

global $product; ?>

<li class="animate">
  <a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
    <div class="img-cont">
      <?php echo $product->get_image(); ?>
    </div>
    <div class="title-container">
      <span class="product-title"><?php echo $product->get_title(); ?></span>
    </div>
  <?php echo $product->get_price_html(); ?>
  </a>
</li>
