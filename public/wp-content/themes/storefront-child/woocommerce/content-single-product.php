<?php
/**
 * The template for displaying product content in the single-product.php template
 **/

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
  global $product, $post;
  $image_ids = $product->get_gallery_attachment_ids();
  $specs = get_field('specifikationer');
  $price = $product->price;
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" class="sinus single-product">

<div class="single-product icons">
  <div class="text-icon">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 47.69 43.95" class="texticon"><line class="a" y1="3.79" x2="25.83" y2="3.79"/><line class="a" y1="15.64" x2="33.62" y2="15.64"/><line class="a" x1="28.53" y1="3.79" x2="47.52" y2="3.79"/><line class="a" y1="40.15" x2="18.99" y2="40.15"/><line class="a" x1="21.32" y1="40.15" x2="47.69" y2="40.15"/><line class="a" x1="35.81" y1="15.64" x2="47.52" y2="15.64"/><line class="a" y1="27.79" x2="7.85" y2="27.79"/><line class="a" x1="10.13" y1="27.79" x2="47.52" y2="27.79"/></svg>
  </div>
  <?php if ( $price ) { ?>
  <div class="add-button single-product" data-href="<?php echo $product->id; ?>" data-title="<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>">
      <svg version="1.1" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         x="0px" y="0px" viewBox="0 0 60 60" xml:space="preserve" class="addicon">
      <line class="svg-line" fill="none" stroke="#007c96" stroke-width="10" stroke-miterlimit="10" x1="30" y1="6" x2="30" y2="54"/>
      <line class="svg-line" fill="none" stroke="#007c96" stroke-width="10" stroke-miterlimit="10" x1="6" y1="30" x2="54" y2="30"/>
      </svg>
  </div>
  <?php } ?>

</div>
  <?php // Images
    if ( has_post_thumbnail() ) {
      $image_title  = esc_attr( get_the_title( get_post_thumbnail_id() ) );
      $image_caption  = get_post( get_post_thumbnail_id() )->post_excerpt;
      $image        = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
        'title' => $image_title,
        'alt' => $image_title
        ) );
    } else {
      echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
    }

    $attachment_count = count( $image_ids );

    if ( $attachment_count >= 1 ) {

      echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="main-image" itemprop="image">%s</div>', $image ), $post->ID );

      $img_loop = 0; ?>

      <div class="product-images">
      <?php
      foreach( $image_ids as $id ) {

        if ( $img_loop == 2 ) {
          $vid_url = get_field('youtube');
          if ($vid_url) { ?>
            <div class="youtube-frame" data-href="<?php echo $vid_url ?>"></div>
          <?php }
        } else {

        $image = wp_get_attachment_image( $id,  apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), 0, $attr = array('title' => $image_title, 'alt' => $image_title) );
          echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="product-image image-%s"  itemprop="image">%s</div>', $img_loop, $image ), $id, $post->ID );
        }
        $img_loop++;
      }

      ?> </div> <?php

    } elseif ( $attachment_count < 1 ) {
      echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="main-image" itemprop="image">%s</div>', $image ), $post->ID );

      $vid_url = get_field('youtube');
        if ($vid_url) { ?>
          <div class="product-images">
            <div class="youtube-frame" data-href="<?php echo $vid_url ?>"></div>
          </div>
      <?php }
    }
  ?>

  <div class="product-content">
    <div class="product-left">
      <h1 class="single-product-title" itemprop="model"><?php the_title(); ?></h1>
      <?php the_content(); ?>
    </div>


    <div class="product-right">

    <?php
    if ( $price ) { ?>
      <div class="product-controls">
        <div class="product-price">
          <h2><?php echo $product->price . ',-'; ?></h2>
        </div>
        <div class="add-button large" data-href="<?php echo $product->id; ?>" data-title="<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>">
          <h3>Læg i kurv</h3>
        </div>
      </div>
    <?php } else { ?>
      <div class="product-controls">
        <span class="no-price">Kontakt os for information og pris.</span>
      </div>
    <?php
    }

    if ( $specs) { ?>
      <div class="product-text-right">
        <h3 class="specs">Specifikationer:</h3>
        <p class="specs"><?php the_field('specifikationer'); ?></p>
      </div>
    <?php } ?>
    </div>
  </div>

  <meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php //do_action( 'woocommerce_after_single_product' ); ?>
