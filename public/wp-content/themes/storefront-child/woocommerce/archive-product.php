<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

get_header();

if ( $_GET['brand'] ) {
  $current_brand = $_GET['brand'];
}

$current_category = single_cat_title("", false);

?>

    <div class="product-list-grid" data-type="<?php echo $current_category; ?>" data-brand="<?php echo $current_brand; ?>">
    <h1><?php echo $current_category; ?></h1>
    <h1><?php echo $current_brand; ?></h1>

    </div>

<?php get_footer( 'shop' ); ?>
