<?php
/**
 * The template for displaying product content in the single-product.php template
 **/

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
  global $product, $post;
  $image_ids = $product->get_gallery_attachment_ids();
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" class="sinus single-product">
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

      $img_loop = 0;
      foreach( $image_ids as $id ) {
        $image = wp_get_attachment_image( $id,  apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), 0, $attr = array(
      'title' => $image_title,
      'alt' => $image_title
      ) );;
          echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="product-image image-%s"  itemprop="image">%s</div>', $img_loop, $image ), $id, $post->ID );
        $img_loop++;
      }
    } elseif ( $attachment_count < 1 ) {
      echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="main-image" itemprop="image">%s</div>', $image ), $post->ID );
    }
  ?>

  <div class="product-content">
    <div class="main-description">
      <h1 class="single-product-title" itemprop="model"><?php the_title(); ?></h1>
      <?php the_content(); ?>
    </div>
    <div class="product-specs">
      <h3 class="specs">Specifikationer:</h3>
      <p class="specs"><?php the_field('specifikationer'); ?></p>
    </div>

    <?php
      $vid_url = get_field('youtube');
      if ($vid_url) { ?>
        <div class="youtube-frame" data-href="<?php echo $vid_url ?>"></div>
      <?php } ?>
  </div>

  <meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php //do_action( 'woocommerce_after_single_product' ); ?>
