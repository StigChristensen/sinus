<?php
/*
Plugin Name: Sinus Store - Export Products
Plugin URI:  https://www.sinus-store.dk
Description: Export products for squareup.com
Version:     1.0.0
Author:      Stig Christensen
*/

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$filename = 'sinus_products.csv';
$dir = plugin_dir_path( __FILE__ );

function register_admin_page() {
    add_dashboard_page( 'Export Products', 'Export Products', 'edit_pages', 'export-products-page', 'export_products_callback' );
}
add_action('admin_menu', 'register_admin_page');

function export_assets() {
  wp_enqueue_script( 'export_js', plugins_url() . '/sinus-export-products/js/export.js', array('jquery'), '1.0.0', true );
  wp_localize_script('export_js', 'exp', array( 'export_url' => admin_url( 'admin-ajax.php' ) ));
}
add_action( 'admin_init','export_assets');

// register ajax call
add_action( 'wp_ajax_export_products', 'sinus_export' );

function sinus_export() {
  global $client;
  $csv_fields = "title,categories,regular_price";

  try {
    $export_products = $client->products->get(null,
      array(
        'filter[limit]'   => -1,
        'fields'          => $csv_fields,
        )
    );
  } catch ( WC_API_Client_Exception $e ) {
    echo $e;
  }

  if ( $export_products ) {
    $rows = json_decode(json_encode($export_products->products), true);
     export_file($rows);
  }

 wp_die();
}

function export_file($rows) {
  global $filename, $dir;
  // Output csv data
  $filecontent = "Item ID,Name,Category,Description,Variant 1 - Name,Variant 1 - Price,Variant 1 - SKU,Variant 2 - Name,Variant 2 - Price,Variant 2 - SKU,Variant 3 - Name,Variant 3 - Price,Variant 3 - SKU,Tax - Moms (25%)\r\n";

  foreach ($rows as $row) {
    $cats = "";
    foreach ($row['categories'] as $c ) {
      $cats .= $c . " ";
    }

    $title = str_replace(",", ".", $row['title']);
    $price = str_replace(".00", "", $row['regular_price']);

    $filecontent .= ",".$title.",".$cats.",".$title.",".$title.",".$price.".000000".",,,,,,,,"."Y"."\r\n";
  }

  echo $dir . $filename;

  $csv_filename = $filename;
  $fd = fopen ($dir . $csv_filename, "w");
  if ( $fd ) {
    fputs($fd, $filecontent);
    fclose($fd);
    echo "Success";
  } else {
    echo "Error";
  }

}

// show something on the page
function export_products_callback() {
  echo '<h1>Sinus Store - Export Products</h1>';
  echo '<a class="export-btn" href="#"><h3>EXPORT</h3></a>';
}

?>
