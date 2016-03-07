<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

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

  header("Content-type: application/vnd.ms-excel");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Pragma: no-cache");
  header("Expires: 0");
  header("Content-Disposition: attachment; filename=sinus_store_products.csv");

  // Output csv data
  $filecontent = "Item ID,Name,Category,Description,Variant 1 - Name,Variant 1 - Price,Variant 1 - SKU,Variant 2 - Name,Variant 2 - Price,Variant 2 - SKU,Variant 3 - Name,Variant 3 - Price,Variant 3 - SKU,Tax - Moms (25%)\r\n";

  foreach ($rows as $row) {
    $cats = "";
    foreach ($row['categories'] as $c ) {
      $cats .= $c. " ";
    }
    $filecontent .= ",".$row['title'].",".$cats.",".$row['title'].",".$row['title'].",".$row['regular_price'].".000000".",,,,,,,,"."Y"."\r\n";
  }

  echo $filecontent;
}


?>
