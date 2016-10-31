<?php
/**
 * product tag equals BRAND
 *
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     9.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

get_header();

global $post;
$args = array( 'taxonomy' => 'product_tag');
$terms = wp_get_post_terms($post->ID,'product_tag', $args);

$q = get_queried_object();
$template_type = "brand";

if ( $q->parent === 0 ) {
  $header = $q->name;
  $parent_term = $q->name;
} else {
  $t = get_term($q->parent);
  $parent_term = $t->name;
  $sub_cat = $q->name;
  $header = $parent_term . " - " . $sub_cat;
}

?>

<div class="product-template wrapper">
  <div class="product-header">
    <div class="product-headline">
      <h1><?php echo $header; ?></h1>
    </div>

    <div class="template-description">
      <span class="desc"><?php echo $q->description; ?></span>
    </div>
  </div>

      <div class="template brand products-container" data-templatetype="<?php echo $template_type; ?>" data-brand="<?php echo $parent_term; ?>" >
          <div class="product-list-grid">
            <div class="template page products">
              <ul class="template products">
              <?php while ( have_posts() ) : the_post(); ?>

                <?php wc_get_template_part( 'content', 'single-product-grid' ); ?>

              <?php endwhile; // end of the loop. ?>
              </ul>
            </div>
          </div>
      </div>
</div>
<?php get_footer(); ?>
