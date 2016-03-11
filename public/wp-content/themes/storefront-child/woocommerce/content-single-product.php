<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * @see       http://docs.woothemes.com/document/template-structure/
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>

<div class="single-product-container">

<?php
  global $product, $post;
  $image_ids = $product->get_gallery_attachment_ids();
  $specs = get_field('specifikationer');
  $price = $product->price;
  $quantity = $product->stock_quantity;
?>

  <div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" class="sinus single-product">

  <div class="images-cntrl">

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

        <div class="product-images thumbs">
        <?php
        foreach( $image_ids as $id ) {
            $image = wp_get_attachment_image( $id,  apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), 0, $attr = array('title' => $image_title, 'alt' => $image_title) );
              echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="product-image image-%s"  itemprop="image">%s</div>', $img_loop, $image ), $id, $post->ID );
            $img_loop++;
        } ?>
        </div>

      <?php } elseif ( $attachment_count < 1 ) {
        echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="main-image single" itemprop="image">%s</div>', $image ), $post->ID );
      }
    ?>
    </div>


    <div class="product-content">
      <div class="content-bg">
        <img src="<?php echo get_stylesheet_directory_uri() . '/img/bg/bg5.png'; ?>" alt="Content background image" />
      </div>
      <div class="product-left">
        <h1 class="single-product-title" itemprop="model"><?php the_title(); ?></h1>
        <?php the_content(); ?>
      </div>

      <div class="product-right">
        <?php
        if ( $price ) { ?>
          <div class="product-controls">
            <div class="product-price">
              <h2><?php echo $product->price . ',- kr.'; ?></h2>
            </div>
            <div class="add-button large" data-href="<?php echo $product->id; ?>" data-title="<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>">
              <h3>Læg i kurv</h3>
            </div>
            <?php echo '<h1>' . $quantity . '</h1>'; ?>
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

  </div><!-- #product-<?php the_ID(); ?> -->
</div>
<?php //do_action( 'woocommerce_after_single_product' ); ?>
