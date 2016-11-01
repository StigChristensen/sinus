<?php
/**
* The template for displaying the filtering options on product pages
*
* HOVEDTELEFONER
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
    <div class="filters left">
      <input type='checkbox' class='over-ear' name='over-ear' value='' id="over-ear" unchecked /><label for="over-ear"><i class="fa fa-check-square"></i> <h4>Over-Ear</h4></label>
      <input type='checkbox' class='on-ear' name='on-ear' value='' id="on-ear" unchecked /><label for="on-ear"><i class="fa fa-check-square"></i> <h4>On-Ear</h4></label>
      <input type='checkbox' class='in-ear' name='in-ear' value='' id="in-ear" unchecked /><label for="in-ear"><i class="fa fa-check-square"></i> <h4>in-Ear</h4></label>
    </div>

    <div class="filters center-left">
      <input type='checkbox' class='street' name='street' value='' id="street" unchecked /><label for="street"><i class="fa fa-check-square"></i> <h4>street</h4></label>
      <input type='checkbox' class='sport' name='sport' value='' id="sport" unchecked /><label for="sport"><i class="fa fa-check-square"></i> <h4>sport</h4></label>
      <input type='checkbox' class='studie' name='studie' value='' id="studie" unchecked /><label for="studie"><i class="fa fa-check-square"></i> <h4>studie</h4></label>
    </div>

    <div class="filters center-right">
      <input type='checkbox' class='dj' name='dj' value='' id="dj" unchecked /><label for="dj"><i class="fa fa-check-square"></i> <h4>dj</h4></label>
      <input type='checkbox' class='hifi' name='hifi' value='' id="hifi" unchecked /><label for="hifi"><i class="fa fa-check-square"></i> <h4>hifi</h4></label>
      <input type='checkbox' class='gaming' name='gaming' value='' id="gaming" unchecked /><label for="gaming"><i class="fa fa-check-square"></i> <h4>gaming</h4></label>
    </div>

    <div class="filters right">
      <input type='checkbox' class='mikrofon' name='mikrofon' value='' id="mikrofon" unchecked /><label for="mikrofon"><i class="fa fa-check-square"></i> <h4>mikrofon</h4></label>
      <input type='checkbox' class='noise-cancelling' name='noise-cancelling' value='' id="noise-cancelling" unchecked /><label for="noise-cancelling"><i class="fa fa-check-square"></i> <h4>noise-cancelling</h4></label>
      <input type='checkbox' class='wireless' name='wireless' value='' id="wireless" unchecked /><label for="wireless"><i class="fa fa-check-square"></i> <h4>wireless</h4></label>
    </div>

    <div class="filters bottom">
      <input type='checkbox' class='pris_lav' name='pris_lav' data-range="0-1000" value='' id="pris_lav" unchecked /><label for="pris_lav"><i class="fa fa-check-square"></i> <h4>Pris: 0-1000 kr.</h4></label>

      <input type='checkbox' class='pris_med' name='pris_med' data-range="1000-3000" value='' id="pris_med" unchecked /><label for="pris_med"><i class="fa fa-check-square"></i> <h4>Pris: 1000-3000 kr.</h4></label>

      <input type='checkbox' class='pris_top' name='pris_top' data-range="3000-30000" value='' id="pris_top" unchecked /><label for="pris_top"><i class="fa fa-check-square"></i> <h4>Pris: 3000-???? kr.</h4></label>

    </div>

    <div class="filter-button">
      <h4>Filtrer <i class="fa fa-chevron-right"></i></h4>
    </div>
</div>

<div class="filters-info-box not-expanded">
  <div class="no-results">
    <h3>Vi fandt desværre ingen resultater.</h3>
    <span>For at gøre søgningen mere specifik lægges valgmulighederne sammen, så du f.eks. kan finde in-ear hovedtelefoner til sport og street i prisrammen 0-1000kr. Men det kan også resultere i at man søger så specifikt, at der ingen resultater er. Prøv derfor at fjerne nogle valgmuligheder.</span>
  </div>

</div>
