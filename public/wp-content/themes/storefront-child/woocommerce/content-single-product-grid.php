<?php
/**
 * The template for displaying product content in the loops on the front page - Sinus, custom.
 **/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

global $product, $post;
$qty = $product->get_stock_quantity();
$terms = get_the_terms( $post->ID, 'product_cat' );
$classes = array();
foreach ( $terms as $term ){
    $category_slug = $term->slug;
    $classes[] = $category_slug;
}

$class_string = implode(" ", $classes);
$content = get_the_content();
$trimmed = wp_trim_words($content, 28, ' ... KLIK FOR MERE');
?>

<?php
if ( $qty == 0 ) {
  $stockIcon = '<div class="in-stock-icon"><span>PÅ LAGER: <i class="fa fa-minus-square"></i></span></div>';
  $stockClass = 'stock-false';
}

if ( $qty > 0 ) {
  $stockIcon = '<div class="in-stock-icon"><span>PÅ LAGER: <i class="fa fa-check-square"></i></span></div>';
  $stockClass = 'stock-true';
}

?>

<li class="product <?php echo $class_string . ' ' . $stockClass; ?>" itemscope itemtype="http://schema.org/Product" data-singleid="<?php the_ID(); ?>" data-sort="<?php echo $class_string; ?>" data-stock="<?php echo $stockClass; ?>">
  <a href="<?php the_permalink(); ?>"><div class="click-area"></div></a>
  <?php echo $stockIcon; ?>
  <?php echo $product->get_image(); ?>
  <div class="product-title" itemprop="name"><h3><?php the_title(); ?></h3></div>
  <div class="product-price"><?php echo $product->get_price_html(); ?><div class="add-button" data-href="<?php the_ID(); ?>" data-title="<?php the_title(); ?>"><svg version="1.1" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"x="0px" y="0px" viewBox="0 0 60 60" xml:space="preserve"><line class="svg-line" fill="none" stroke="#007c96" stroke-width="10" stroke-miterlimit="10" x1="30" y1="6" x2="30" y2="54"/><line class="svg-line" fill="none" stroke="#007c96" stroke-width="10" stroke-miterlimit="10" x1="6" y1="30" x2="54" y2="30"/></svg><span class="add-info">Tilføj til kurv</span></div></div>
  <div class="sinus-product-info"><div class="short-desc" itemprop="description"><p><?php echo $trimmed; ?></p><i class="fa fa-chevron-circle-up"></i></div></div>
</li>
