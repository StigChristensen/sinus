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

// get_header();

// if ( $_GET && $_GET['side'] ) {
//   $page_num = $_GET['side'];
// }

// global $post;
// $args = array( 'taxonomy' => 'product_tag',);
// $terms = wp_get_post_terms($post->ID,'product_tag', $args);

// $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

// $args = array(
//   'post_type' => 'product',
//   'posts_per_page' => 24,
//   'fields' => 'id',
//   'paged' => $paged,
//   'tax_query' => array(
//     array(
//       'taxonomy' => 'product_tag',
//       'field'    => 'slug',
//       'terms'    => $terms[0]->slug,
//     ),
//   ),
// );

// $postslist = new WP_Query( $args );
// $totalpages = $postslist->max_num_pages;

wc_get_template( 'archive-product.php' );
?>

<!--     <div class="products-container" data-cat="" data-tag="<?php echo $terms[0]->slug; ?>" data-page="<?php echo $page_num; ?>" data-maxpages="<?php echo $totalpages; ?>">
        <div class="spinner hidden"><div class="circle"></div><div class="circle1"></div></div>
        <div class="product-list-grid"><ul class="products"></ul>
        </div>
    </div> -->

<?php // get_footer( 'shop' ); ?>
