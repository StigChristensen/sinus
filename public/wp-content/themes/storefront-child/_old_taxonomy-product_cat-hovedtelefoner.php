<?php
/**
 * product cat equals Product TYPE in the frontend
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     9.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

get_header();

global $post;
$args = array( 'taxonomy' => 'product_cat');
$terms = wp_get_post_terms($post->ID,'product_cat', $args);
$name = $terms[0]->name;

$args = array( 'taxonomy' => 'product_tag');
$brands = wp_get_post_terms($post->ID,'product_tag', $args);
?>

<div class="product-template wrapper">
  <div class="product-header">
    <div class="product-headline">
      <h1>Hovedtelefoner</h1>
    </div>

    <div class="template-description">
      <span class="desc"><?php echo $terms[0]->description; ?></span>
    </div>
  </div>

  <div class="filters-wrap">
    <?php
      // Get product filtering template
      get_template_part( 'content', 'filtering-headphones' );
    ?>
</div>

      <div class="template products-container" data-type="<?php echo $terms[0]->slug; ?>" >
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
