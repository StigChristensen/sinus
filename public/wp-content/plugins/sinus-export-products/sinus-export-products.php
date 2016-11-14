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

$time = time();
$filename = 'sinus_products_.csv';
$dir = plugin_dir_path( __FILE__ );

function register_admin_page() {
    add_dashboard_page( 'Export Products', 'Export Products', 'edit_pages', 'export-products-page', 'export_products_callback' );
}
add_action('admin_menu', 'register_admin_page');

function export_assets() {
  wp_enqueue_script( 'export_js', plugins_url() . '/sinus-export-products/js/export.js', array('jquery'), '1.0.0', true );
  wp_enqueue_style( 'export_css', plugins_url() . '/sinus-export-products/css/export_css.css' );
  wp_localize_script('export_js', 'exp', array( 'export_url' => admin_url( 'admin-ajax.php' ), 'site' => site_url() ));
}
add_action( 'admin_init','export_assets');

// register ajax call
add_action( 'wp_ajax_export_products', 'sinus_export' );

function sinus_export() {
  global $client;
  $csv_fields = "title,categories,regular_price,sale_price";

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
  $filecontent = "Token,Item Name,Description,Category,SKU,Variation Name,Price,Current Quantity,New Quantity,Stock Alert Enabled,Stock Alert Count,Modifier Set - Nr 1,Tax - Moms (25%)\r\n";

  foreach ($rows as $row) {
    $cats = "";
    foreach ($row['categories'] as $c ) {
      $cats .= $c . " ";
    }

    $title = str_replace(",", ".", $row['title']);
    $price = str_replace(".00", "", $row['regular_price']);

    if ( $row['sale_price'] ) {
      $sale = str_replace(".00", ".000000", $row['sale_price']);
    } else {
      $sale = "";
    }

    $filecontent .= "," . $title . "," . "," . "$cats" . "," . "," . $title . "," . $price . "," . ",,,," . "N" . "," . "Y" . "\r\n";
    // $filecontent .= ",".$title.",".$cats.",".$title.",".$title.",".$price.".000000".",,".$title.' Tilbud'.",".$sale.",,,,,"."Y"."\r\n";
  }

  $csv_filename = $filename;
  $fd = fopen ($dir . $csv_filename, "w");
  if ( $fd ) {
    fputs($fd, $filecontent);
    fclose($fd);
    $return = $dir . $filename;
  } else {
    $return = 'Error';
  }

  echo json_encode($return);

  wp_die();
}

// show something on the page
function export_products_callback() {
  $imgurl_a = plugins_url() . '/sinus-export-products/img/img1.png';
  $imgurl_b = plugins_url() . '/sinus-export-products/img/img2.png';


  echo '<div class="export top"><h1>Sinus Store - Export Products</h1>';
  echo '<p>Klik på EXPORT knappen og afvent, at linket til filen kommer frem. Klik på den, eller højre-klik på den og vælg "Gem som..." eller lignende.</p><br>';
  echo '<a class="export-btn" href="#">EXPORT</a>';

  echo '<div class="export result"><div class="export-spin"><h4>...</h4></div>';
  echo '<div class="link"></div></div>';

  echo '<p>Log ind på square-up. Og klik "IMPORT/EXPORT" -> "Import Items"</p>';
  echo '<img src="' . $imgurl_a . '" />';
  echo '<p>Vælg "Replace Library"</p>';
  echo '<img src="' . $imgurl_b . '" />';
  echo '<p>Upload filen og tryk godkend, når den er gået igennem.</p></div>';


}

?>
