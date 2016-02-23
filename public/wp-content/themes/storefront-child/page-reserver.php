<?php
/**
 * Template Name: Sinus Cart Page
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

get_header();

global $woocommerce, $post;
$order = new WC_Order($post->ID);

$qty = WC()->cart->get_cart_contents_count();
$calc_shipping = WC()->cart->calculate_shipping();
$shipping = WC()->cart->get_cart_shipping_total();
$cart = WC()->cart->get_cart();
$total = WC()->cart->get_cart_total();
?>

<div class="reserve-form-container">
  <div class="page-header"><h1>Reserver varerne og hent dem i butikken</h1></div>
  <div class="text-content">
    <p>Du har mulighed for, at lægge varerne til side og afhente og betale dem i butikken indenfor to hverdage.<br>
    Udfyld formen forneden og vi lægger varerne i din kurv til side. <br>Du modtager en bekræftelsesmail, når du har udfyldt og indsendt formen.<br>
    Har du spørgsmål eller brug for andet, så kontakt os i butikken.
    </p>
  </div>

  <form class="reserve">
    <input type="text" class="name" name="name" id="name" placeholder="FORNAVN OG EFTERNAVN" />
    <input type="text" class="phone" name="phone" id="phone" placeholder="TELEFON" />
    <input type="email" name="email" id="email" placeholder="EMAIL" />
    <div class="submit-btn"><a href="#">Læg til side</a></div>
  </form>

  <div class="validation success">
    <h4>Tak for din bestilling.</h4>
    <p>Varerne vil blive lagt til side i butikken.</p>
  </div>

</div>




<?php
get_footer();
?>

