<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * @see
 * @author
 * @package
 * @version   99.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<script src="<?php echo get_stylesheet_directory_uri() . '/js/singleProductPage.js'; ?>" async defer></script>


<div class="single-product-container">

<?php
  global $product, $post;
  $image_ids = $product->get_gallery_attachment_ids();
  $specs = get_field('specifikationer');
  $price = $product->price;
  $qty = $product->get_stock_quantity();

  if ( $qty == 0 ) {
    $stockIcon = '<div class="in-stock-icon"><span>IKKE PÅ LAGER: <i class="fa fa-minus-square"></i></span></div>';
    $stockClass = 'stock-false';
  }

  if ( $qty > 0 ) {
    $stockIcon = '<div class="in-stock-icon"><span>PÅ LAGER: <i class="fa fa-check-square"></i></span></div>';
    $stockClass = 'stock-true';
  }
?>

  <div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" class="sinus single-product <?php echo $stockClass; ?>">

    <h1 class="single-product-title" itemprop="name"><?php the_title(); ?></h1>

    <?php // Images
      if ( has_post_thumbnail() ) {
        $image_title  = esc_attr( get_the_title( get_post_thumbnail_id() ) );
        $image_caption  = get_post( get_post_thumbnail_id() )->post_excerpt;
        $image = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array('title' => $image_title, 'alt' => $image_title) );
      } else {
        echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
      }

      $attachment_count = count( $image_ids );

      if ( $attachment_count >= 1 ) { ?>

        <div class="images-cntrl">

        <?php
        $main_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "large" );

        echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="main-image" itemprop="image" data-fullsrc="' . $main_src[0] . '">%s</div>', $image ), $post->ID );

        $img_loop = 0; ?>

        <div class="product-images thumbs">
        <?php
        foreach( $image_ids as $id ) {

          if ( $img_loop == 8 ) {
            break;
          }

          $large_src = wp_get_attachment_image_src($id, $size = 'large', false);

          $image = wp_get_attachment_image( $id,  apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), 0, $attr = array('title' => $image_title, 'alt' => $image_title) );

            echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="product-image image-%s" itemprop="product image" data-fullsrc="' . $large_src[0] . '">%s</div>', $img_loop, $image ), $id, $post->ID );

          $img_loop++;

        } ?>

        </div>

        <?php if ( $price ) { ?>

          <?php if ( $attachment_count <= 6 ): ?>
            <div class="product-price">
              <h2><?php echo $product->price . ',- kr.'; ?></h2>
            </div>
            <div class="add-button large" data-href="<?php echo $product->id; ?>" data-title="<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>">
              <h3>Læg i kurv</h3>
            </div>
            <?php echo $stockIcon; ?>
          <?php endif; ?>

          <?php if ( $attachment_count >= 7 ): ?>
            <div class="product-controls-row single-image">
              <?php echo $stockIcon; ?>
              <div class="row-product-price">
                <h2><?php echo $product->price . ',- kr.'; ?></h2>
              </div>
              <div class="add-button large" data-href="<?php echo $product->id; ?>" data-title="<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>">
                <h3>Læg i kurv</h3>
              </div>
            </div>
          <?php endif; ?>

        <?php } else { ?>
            <span class="no-price">Kontakt os for information og pris.</span>
        <?php } ?>
      </div>

    <?php } elseif ( $attachment_count < 1 ) { ?>

      <div class="single-image-cntrl">
      <?php
        $main_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), $size = 'large', false);

        echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="main-image single" itemprop="product image" data-fullsrc="' . $main_src[0] . '">%s</div>', $image ), $post->ID ); ?>

        <?php
        if ( $price ) { ?>
          <div class="product-controls-row single-image">
            <?php echo $stockIcon; ?>
            <div class="row-product-price">
              <h2><?php echo $product->price . ',- kr.'; ?></h2>
            </div>
            <div class="add-button large" data-href="<?php echo $product->id; ?>" data-title="<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>">
              <h3>Læg i kurv</h3>
            </div>
          </div>
        <?php } else { ?>
          <div class="product-controls">
            <span class="no-price">Kontakt os for information og pris.</span>
          </div>
        <?php } ?>

      </div>

    <?php } ?>


    <div class="product-content">
      <div class="text-content">
        <div class="product-main">
          <?php the_content(); ?>

          <?php
          if ( $price ) { ?>
            <div class="product-controls">
              <div class="product-price">
                <h2><?php echo $product->price . ',- kr.'; ?></h2>
              </div>
              <div class="add-button large" data-href="<?php echo $product->id; ?>" data-title="<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>">
                <h3>Læg i kurv</h3>
              </div>
              <?php echo $stockIcon; ?>
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
    </div>

    <?php
    $vid_url = get_field('youtube');
    if ($vid_url) { ?>

    <div class="youtube-frame" data-href="<?php echo $vid_url ?>"></div>

    <?php } ?>

    <?php
    $related = get_field('prod_related');
    $variants = get_field('prod_variants');
    ?>

    <?php if ( $related || $variants ): ?>
    <div class="related-container">

      <?php if ( $variants ): ?>
          <div class="product-variants">
          <h4>Produktvarianter</h4>
            <?php foreach ($variants as $post ) {
              setup_postdata($post); ?>
              <?php wc_get_template_part('content', 'widget-product'); ?>
        <?php }
          wp_reset_postdata(); ?>
          </div>
        <?php endif; ?>

      <?php if ( $related ): ?>
      <div class="related-products">
            <h4>Relaterede Produkter</h4>
            <?php foreach ($related as $post ) {
              setup_postdata($post); ?>
              <?php wc_get_template_part('content', 'widget-product'); ?>
        <?php }
          wp_reset_postdata(); ?>
          </div>
        <?php endif; ?>

    </div>
  <?php endif; ?>

    <meta itemprop="url" content="<?php the_permalink(); ?>" />

  </div>
</div>

<!-- <div class="large-image-modal">

</div> -->
