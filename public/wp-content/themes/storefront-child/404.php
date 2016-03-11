<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package storefront
 */
?>

<section class="no-results not-found">
  <header class="page-header">
    <h1 class="page-title"><?php _e( 'Nothing Found', 'storefront' ); ?></h1>
  </header><!-- .page-header -->

  <div class="page-content">
    <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

      <p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'storefront' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

    <?php elseif ( is_search() ) : ?>

      <p>Vi kunne desværre ikke finde det, som du søgte efter. Prøv igen - eller brug menuen øverst.</p>


    <?php else : ?>

      <p>Vi kunne desværre ikke finde det, som du søgte efter. Prøv igen - eller brug menuen øverst.</p>

    <?php endif; ?>
  </div><!-- .page-content -->
</section><!-- .no-results -->
