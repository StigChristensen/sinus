<?php
/**
 * Template Name: Sinus Cart Page
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

get_header();

global $woocommerce, $post;
$order = new WC_Order($post->ID);

$qty = WC()->cart->get_cart_contents_count();
$calc_shipping = WC()->cart->calculate_shipping();
$shipping = WC()->cart->get_cart_shipping_total();
$cart = WC()->cart->get_cart();
$total = WC()->cart->get_cart_total();
?>


<div class="cart-page-container">

  <div class="cart-contents">
    <h1>Din Kurv</h1>
    <div class="cart-count"><p class="small">Antal varer: <?php echo $qty; ?></p></div>

    <?php foreach ($cart as $ca) { ?>
    <?php
      $product = new WC_Product( $ca['product_id'] );
      $price = $product->price;
    ?>
      <div class="cart-element">
        <div class="remove-icon" data-id="<?php echo $ca['product_id']; ?>"><p><i class="fa fa-times-circle-o"></i></p></div>
        <a href="<?php the_permalink($ca['product_id']); ?>"><div class="elem-title"><h3><?php echo get_the_title($ca['product_id']); ?></h3></div></a>
        <div class="elem-qty-total" data-qty="<?php echo $ca['quantity']; ?>"><h3>
        <?php
        if ( $ca['quantity'] > 1 ) {
          echo $ca['quantity'] . ' x ' . $price . ',- kr.';
        } else {
          echo $price . ',- kr.';
        } ?>
        </h3></div>
      </div>

    <?php } ?>

    <div class="cart-total">
        <p class="small">I alt: </p><h2><?php echo $total; ?></h2>
        <p class="small">(inkl. moms)</p>

      <?php if ( $shipping == "Free!" ) { ?>
        <p class="small">Plus fragt: 0,- Kr.</p>
        <span class="small">Fri fragt på køb over 1.000,- kr.</span>
        <?php } else { ?>
          <p class="small">Plus fragt: <?php echo $shipping; ?></p>
          <span class="small">Fri fragt på køb over 1.000,- kr.</span>
      <?php } ?>
    </div>

    <div class="cart-page reserver-link"><a class="reserve" href="/reserver">Reserver</a></div>
    <div class="cart-page checkout-link"><a class="cart" href="/checkud">Check ud</a></div>

  </div>
</div>

<?php
get_footer();
?>

