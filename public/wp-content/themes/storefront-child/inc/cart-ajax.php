function woocommerce_header_add_to_cart_fragment( $fragments ) {
  ob_start();
  ?>

  <?php
      $qty = $woocommerce->cart->get_cart_contents_count();
      $total = $woocommerce->cart->get_cart_total();
      $cart_url = $woocommerce->cart->get_cart_url();
      $checkout_url = $woocommerce->cart->get_checkout_url();
      $cart = $woocommerce->cart->get_cart(); ?>

   <div class="cart-contents hidden">

    <div class="arrow-up">
      <img src="<?php echo get_stylesheet_directory_uri() . '/img/arrowup.png'; ?>">
    </div>

     <?php if ( $qty < 1 ) { ?>
        <div class="cart-empty"><h4 class="cart">Din kurv er tom...</h4></div>
      <?php } ?>

      <?php if ( $qty >= 1 ) { ?>

        <div class="cart-container">
          <div class="cart-count"><p class="small">Antal varer: <?php echo $qty; ?></p></div>

          <?php foreach ($cart as $ca) { ?>
          <?php
            $product = new WC_Product( $ca['product_id'] );
            $price = $product->price;
          ?>
            <div class="cart-element">
              <div class="elem-title"><p><?php echo get_the_title($ca['product_id']); ?></p></div>
              <div class="elem-qty-total"><p>
              <?php
              if ( $ca['quantity'] > 1 ) {
                echo $ca['quantity'] . ' x ' . $price . ',- kr.';
              } else {
                echo $price . ',- kr.';
              } ?>
              </p></div>
            </div>

          <?php } ?>

          <div class="cart-total">
            <p class="small">I alt: </p><h4><?php echo $total; ?></h4>
            <p class="small">(inkl. moms)</p>
          </div>

          <div class="cart-link first"><a class="cart" href="<?php echo $cart_url; ?>">Kurv</a></div>
          <div class="cart-link second"><a class="cart" href="<?php echo $checkout_url; ?>">Check ud</a></div>

        </div>
      <?php } ?>
  </div>

  <?php

  $fragments['.cart-contents'] = ob_get_clean();

  return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
