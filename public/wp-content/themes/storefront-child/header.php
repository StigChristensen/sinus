<?php
/**
 * The template for displaying the header
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<script>(function(){document.documentElement.className='js'})();</script>
	<?php wp_head(); ?>
</head>

<body>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-68929510-1', 'auto');
  ga('send', 'pageview');

</script>


<div class="menu-icon">
  <svg class="menu" version="1.1" baseProfile="tiny" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
     y="0px" viewBox="0 0 60 60" xml:space="preserve">
  <g class="icon-bg">
    <rect fill="#4FD5CA" width="60" height="60"/>
  </g>
  <g id="Layer_2">
    <line class="menu-line first" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-miterlimit="10" x1="14" y1="21.5" x2="45" y2="21.5"/>
    <line class="menu-line middle" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-miterlimit="10" x1="14" y1="30.5" x2="45" y2="30.5"/>
    <line class="menu-line last" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-miterlimit="10" x1="14" y1="39.5" x2="45" y2="39.5"/>
  </g>
  </svg>
</div>

<div class="main-menu hidden">
  <div class="menu-categories">
    <h3>Kategorier</h3>
      <ul class="menu-filter">
        <li class="filter">
          <a href="/type/headphones/street/"><p>Street</p></a>
        </li>
        <li class="filter">
          <a href="/type/headphones/dj/"><p>DJ</p></a>
        </li>
        <li class="filter">
          <a href="/type/headphones/sport/"><p>Sport</p></a>
        </li>
        <li class="filter">
          <a href="/type/headphones/gaming/"><p>Gaming</p></a>
        </li>
        <li class="filter">
          <a href="/type/headphones/studie/"><p>Studie</p></a>
        </li>
        <li class="filter">
          <a href="/type/headphones/inear/"><p>In-Ear</p></a>
        </li>
        <li class="filter">
          <a href="/type/headphones/wireless/"><p>Wireless</p></a>
        </li>
        <li class="filter">
          <a href="/type/headphones/noise-cancelling/"><p>Noise-Cancelling</p></a>
        </li>
      </ul>
  </div>
  <div class="menu-brands">
    <h3>Brands</h3>
      <ul class="menu-filter">
        <?php
          $tags = get_terms('product_tag');
          foreach( $tags as $tag ) {
          ?>
            <li class="filter"><a href="<?php echo site_url() . '/brands/' . $tag->slug; ?>"><?php echo $tag->name; ?></a></li>
          <?php } ?>
  </div>
</div>


<div id="content" class="site-content">
  <?php global $woocommerce;
      $qty = $woocommerce->cart->get_cart_contents_count();
      $total = $woocommerce->cart->get_cart_total();
      $cart_url = $woocommerce->cart->get_cart_url();
      $checkout_url = $woocommerce->cart->get_checkout_url();
      $cart = $woocommerce->cart->get_cart(); ?>

  <div class="header head-row-1">
      <div class="headerlogo">
        <a href="<?php echo site_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/img/headerlogo.png'; ?>" ></a>
      </div>
      <div class="sine-animation">
        <div class="img-container">
          <img src="<?php echo get_stylesheet_directory_uri() . '/img/sineanim.png'; ?>">
        </div>
      </div>
      <div class="headermenu">
        <div class="cart-icon">
          <?php if ( $qty < 1 ) { ?>
            <img src="<?php echo get_stylesheet_directory_uri() . '/img/cart-empty.png'; ?>">
          <?php } ?>
          <?php if ( $qty >= 1 ) { ?>
            <img src="<?php echo get_stylesheet_directory_uri() . '/img/cart-full.png'; ?>">
          <?php } ?>
        </div>
      </div>
  </div>


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


  <div class="header head-row-2">
    <div class="search-form">
      <?php get_search_form( true ); ?>
    </div>
  </div>



