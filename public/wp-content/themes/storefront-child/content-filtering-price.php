<?php
/**
* The template for displaying the filtering options for price
*
* PRICE
*
*/

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

global $post;
$args = array( 'taxonomy' => 'product_cat');
$terms = wp_get_post_terms($post->ID,'product_cat', $args);

$args = array( 'taxonomy' => 'product_tag');
$brands = wp_get_post_terms($post->ID,'product_tag', $args);
?>

<div class="filters-container headphones" data-height="600">
    <div class="filters bottom">
      <input type='checkbox' class='pris_lav' name='pris_lav' data-range="0-1000" value='' id="pris_lav" unchecked /><label for="pris_lav"><i class="fa fa-check-square"></i> <h4>Pris: 0-1000 kr.</h4></label>

      <input type='checkbox' class='pris_med' name='pris_med' data-range="1000-3000" value='' id="pris_med" unchecked /><label for="pris_med"><i class="fa fa-check-square"></i> <h4>Pris: 1000-3000 kr.</h4></label>

      <input type='checkbox' class='pris_top' name='pris_top' data-range="3000-30000" value='' id="pris_top" unchecked /><label for="pris_top"><i class="fa fa-check-square"></i> <h4>Pris: 3000-???? kr.</h4></label>

    </div>

    <div class="filter-button">
      <h4>Filtrer <i class="fa fa-chevron-right"></i></h4>
    </div>
</div>
