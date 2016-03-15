<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package storefront
 */

get_header();
?>

<div class="wrap-404">
  <div class="404-content">
    <h3>Vi kunne desværre ikke finde, hvad du søgte efter.</h3>
    <h4>Vi sender dig tilbage til den side du kom fra, om et par sekunder.</h4>

    <script>
      setTimeout(function() {
        window.history.back();
      }, 5000);
    </script>
  </div>
</div>

<?php get_footer(); ?>
