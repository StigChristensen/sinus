<?php
/*
Plugin Name: Sinus - Export to JSON
Plugin URI:  https://www.sinus-store.dk
Description: Export to JSON (Internal use)
Version:     0.0.1
Author:      Stig Christensen
*/

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$filename = 'sinus_';
$dir = plugin_dir_path(__FILE__);

function register_json_page() {
    add_dashboard_page( 'Export JSON', 'Export JSON', 'edit_pages', 'export-json-page', 'export_json_callback' );
}
add_action('admin_menu', 'register_json_page');

function export_json_assets() {
  wp_enqueue_script( 'export_json_js', plugins_url() . '/sinus-json/js/export_json.js', array('jquery'), '1.0.0', true );
  wp_enqueue_style( 'export_json_css', plugins_url() . '/sinus-json/css/export_json.css' );
  wp_localize_script('export_json_js', 'exp', array( 'export_url' => admin_url( 'admin-ajax.php' ), 'site' => site_url() ));
}
add_action( 'admin_init','export_json_assets');

// register ajax call
add_action( 'wp_ajax_export_json', 'sinus_export_json' );

function sinus_export_json() {
  global $client, $dir;

  if ( !$client ) {
    echo 'No client';
    wp_die();
  }

  try {
    $export_products = $client->products->get(null,
      array(
        'filter[limit]'   => 5,
        'filter[offset]'  => 0,
        )
    );
  } catch ( WC_API_Client_Exception $e ) {
    echo json_encode($e);
    wp_die();
  }

  if ( $export_products ) {
    $rows = $export_products->products;
    $type_phones = array();
    $type_speakers = array();
    $type_accessories = array();
    $type_preamps = array();
    $type_dac = array();
    $type_record = array();
    $type_pickup = array();

    foreach ($rows as $row ) {

      if ( in_array("Hovedtelefoner", $row->categories) ) {
        $type_phones[] = $row;
      }

      if ( in_array("Trådløse højttalere", $row->categories) ) {
        $type_speakers[] = $row;
      }

      if ( in_array("Tilbehør", $row->categories) ) {
        $type_accessories[] = $row;
      }

      if ( in_array("Preamps / Hovedtelefonforstærker", $row->categories) ) {
        $type_preamps[] = $row;
      }

      if ( in_array("DAC", $row->categories) ) {
        $type_dac[] = $row;
      }

      if ( in_array("Pladespillere", $row->categories) ) {
        $type_records[] = $row;
      }

      if ( in_array("Pick-up", $row->categories) ) {
        $type_pickup[] = $row;
      }
    }

    $fdp = fopen($dir . "type_hovedtelefoner.json", "w");
    if ( $fdp ) {
      fputs($fdp, json_encode($type_phones));
      fclose($fdp);
      $return[] = "Success - Hovedtelefoner<br>";
    } else {
      $return[] = "Error - type_phones.json";
    }

    $fds = fopen($dir . "type_trådløse.json", "w");
    if ( $fds ) {
      fputs($fds, json_encode($type_speakers));
      fclose($fds);
      $return[] = "Success - Højttalere<br>";
    } else {
      $return[] = "Error - type_speakers.json";
    }

    $fda = fopen($dir . "type_tilbehør.json", "w");
    if ( $fda ) {
      fputs($fda, json_encode($type_accessories));
      fclose($fda);
      $return[] = "Success - Tilbehør<br>";
    } else {
      $return[] = "Error - type_accessories.json";
    }

    $fdpre = fopen($dir . "type_preamps.json", "w");
    if ( $fdpre ) {
      fputs($fdpre, json_encode($type_preamps));
      fclose($fdpre);
      $return[] = "Success - Preamps<br>";
    } else {
      $return[] = "Error - type_preamps.json";
    }

    $fdd = fopen($dir . "type_dac.json", "w");
    if ( $fdd ) {
      fputs($fdd, json_encode($type_dac));
      fclose($fdd);
      $return[] = "Success - DAC<br>";
    } else {
      $return[] = "Error - type_dac.json";
    }

    $fdr = fopen($dir . "type_pladespillere.json", "w");
    if ( $fdr ) {
      fputs($fdr, json_encode($type_records));
      fclose($fdr);
      $return[] = "Success - Pladespillere<br>";
    } else {
      $return[] = "Error - type_pladespillere.json";
    }

    $fdu = fopen($dir . "type_pickup.json", "w");
    if ( $fdu ) {
      fputs($fdu, json_encode($type_pickup));
      fclose($fdu);
      $return[] = "Success - Pick-up<br>";
    } else {
      $return[] = "Error - type_pickup.json";
    }

    echo json_encode($return);
  } else {
    echo 'Query returned no results';
  }

 wp_die();
}

// show something on the page
function export_json_callback() {
  echo '<div class="exportjson top"><h1>Sinus - Export JSON</h1>';
  echo '<p>Klik på EXPORT knappen og afvent. Eksporterer produkter i overordnede kategorier ud som json.</p><br>';
  echo '<a class="exportjson-btn" href="#">EXPORT</a>';

  echo '<div class="exportjson result"><div class="exportjson-spin"><h4>...</h4></div>';
  echo '<div class="outputjson"></div></div>';
}

?>
