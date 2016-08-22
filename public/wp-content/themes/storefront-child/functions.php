<?php

// DEFINE("key", "ck_b8811924622d385bcd26099734be29c0b0b437c4");
// DEFINE("sec", "cs_7aaa1567247c633908ee2f5023f1c70c79535bcc");

// Live
DEFINE("key", "ck_1fe428253a71d9b12917fa9663f874947e763f02");
DEFINE("sec", "cs_fd8f68f1d64916548497311d92f38b9ece0a752f");

// get api
require_once( 'inc/woocommerce-api.php' );
$consumer_key = key;
$consumer_secret = sec;
$api_url = "https://www.sinus-store.dk";

$options = array(
    'ssl_verify'      => false,
    'debug'           => false,
    'return_as_array' => false,
);

try {
  $client = new WC_API_Client( $api_url, $consumer_key, $consumer_secret, $options );
} catch ( WC_API_Client_Exception $e ) {
    echo $e->getMessage() . PHP_EOL;
    echo $e->getCode() . PHP_EOL;
    if ( $e instanceof WC_API_Client_HTTP_Exception ) {
        print_r( $e->get_request() );
        print_r( $e->get_response() );
    }
}

// Hide admin bar on the front facing site, when logged in.
show_admin_bar(false);

// remove other styling
add_filter( 'storefront_customizer_enabled', '__return_false' );
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// Remove unwanted Menu Items in Admin.
function remove_menus() {
  remove_menu_page( 'edit-comments.php' );          //Comments
}
add_action( 'admin_menu', 'remove_menus' );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

function reg_scripts() {
	// wp_enqueue_script( 'vendor', get_stylesheet_directory_uri() . '/js/lib.js', array('jquery'), '1.0.0', true );
	// wp_enqueue_script( 'app', get_stylesheet_directory_uri() . '/js/main.min.js', array( 'vendor' ), '0.0.1', true );
  // wp_localize_script('app', 'site', array( 'theme_path' => get_stylesheet_directory_uri(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'site_url' => get_site_url(), 'key' => key, 'sec' => sec ));

  // wp_enqueue_script( 'app', get_stylesheet_directory_uri() . '/js/grid.js', array(), '0.0.1', false );
  // wp_localize_script('app', 'site', array( 'theme_path' => get_stylesheet_directory_uri(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'site_url' => get_site_url(), 'key' => key, 'sec' => sec ));

	wp_enqueue_style( 'main', get_stylesheet_directory_uri() . '/css/main.min.css', array(), '0.0.1' );
}
add_action( 'wp_enqueue_scripts', 'reg_scripts', 10 );


// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'wd_flush_rewrite_rules' );

// Flush your rewrite rules
function wd_flush_rewrite_rules() {
  flush_rewrite_rules();
}

/**
 * Optimize WooCommerce Scripts
 * Remove WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
 */
add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );

function child_manage_woocommerce_styles() {
 //remove generator meta tag
 remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );

 //first check that woo exists to prevent fatal errors
 if ( function_exists( 'is_woocommerce' ) ) {
 //dequeue scripts and styles
 if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
   wp_dequeue_style( 'woocommerce_frontend_styles' );
   wp_dequeue_style( 'woocommerce_fancybox_styles' );
   wp_dequeue_style( 'woocommerce_chosen_styles' );
   wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
   wp_dequeue_script( 'wc_price_slider' );
   wp_dequeue_script( 'wc-single-product' );
   wp_dequeue_script( 'wc-add-to-cart' );
   wp_dequeue_script( 'wc-cart-fragments' );
   wp_dequeue_script( 'wc-checkout' );
   wp_dequeue_script( 'wc-add-to-cart-variation' );
   wp_dequeue_script( 'wc-single-product' );
   wp_dequeue_script( 'wc-cart' );
   wp_dequeue_script( 'wc-chosen' );
   wp_dequeue_script( 'woocommerce' );
   wp_dequeue_script( 'prettyPhoto' );
   wp_dequeue_script( 'prettyPhoto-init' );
   wp_dequeue_script( 'jquery-blockui' );
   wp_dequeue_script( 'jquery-placeholder' );
   wp_dequeue_script( 'fancybox' );
   wp_dequeue_script( 'jqueryui' );
   }
 }
}

function create_banner() {
  register_post_type( 'Banner', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
    array( 'labels' => array(
      'name' => 'Banner', /* This is the Title of the Group */
      'singular_name' => 'Banner', /* This is the individual type */
      'all_items' => 'All Banners', /* the all items menu item */
      'add_new' => 'Add new', /* The add new menu item */
      'add_new_item' => 'Add new Banner', /* Add New Display Title */
      'edit' => 'Edit', /* Edit Dialog */
      'edit_item' => 'Edit Banner', /* Edit Display Title */
      'new_item' => 'New Banner', /* New Display Title */
      'view_item' => 'See Banner', /* View Display Title */
      'search_items' => 'Search for Banner', /* Search Custom Type Title */
      'not_found' =>  'Nothing found in the database', /* This displays if there are no entries yet */
      'not_found_in_trash' => 'Nothing found in the trash can.', /* This displays if there is nothing in the trash */
      'parent_item_colon' => ''
      ), /* end of arrays */
      'public' => true,
      'publicly_queryable' => true,
      'exclude_from_search' => true,
      'show_ui' => true,
      'query_var' => true,
      'menu_position' => 2, /* this is what order you want it to appear in on the left hand side menu */
      // 'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
      'rewrite' => array( 'slug' => 'banners', 'with_front' => false ), /* you can specify its url slug */
      'has_archive' => 'banner', /* you can rename the slug here */
      'capability_type' => 'post',
      'hierarchical' => false,
      /* the next one is important, it tells what's enabled in the post editor */
      'supports' => array( 'title', 'custom_fields' )
    ) /* end of options */
  ); /* end of register post type */
}
  // adding the function to the Wordpress init
add_action( 'init', 'create_banner');

function create_article() {
  register_post_type( 'Article', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
    array( 'labels' => array(
      'name' => 'Article', /* This is the Title of the Group */
      'singular_name' => 'Article', /* This is the individual type */
      'all_items' => 'All Articles', /* the all items menu item */
      'add_new' => 'Add new', /* The add new menu item */
      'add_new_item' => 'Add new Article', /* Add New Display Title */
      'edit' => 'Edit', /* Edit Dialog */
      'edit_item' => 'Edit Article', /* Edit Display Title */
      'new_item' => 'New Article', /* New Display Title */
      'view_item' => 'See Article', /* View Display Title */
      'search_items' => 'Search for Article', /* Search Custom Type Title */
      'not_found' =>  'Nothing found in the database', /* This displays if there are no entries yet */
      'not_found_in_trash' => 'Nothing found in the trash can.', /* This displays if there is nothing in the trash */
      'parent_item_colon' => ''
      ), /* end of arrays */
      'public' => true,
      'publicly_queryable' => true,
      'exclude_from_search' => true,
      'show_ui' => true,
      'query_var' => true,
      'menu_position' => 4, /* this is what order you want it to appear in on the left hand side menu */
      // 'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
      'rewrite' => array( 'slug' => 'Articles', 'with_front' => false ), /* you can specify its url slug */
      'has_archive' => 'Article', /* you can rename the slug here */
      'capability_type' => 'post',
      'hierarchical' => false,
      /* the next one is important, it tells what's enabled in the post editor */
      'supports' => array( 'title', 'custom_fields' )
    ) /* end of options */
  ); /* end of register post type */
}
  // adding the function to the Wordpress init
add_action( 'init', 'create_Article');



// remove empty p tags
function remove_empty_p( $content ) {
    $content = force_balance_tags( $content );
    $content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
    $content = preg_replace( '~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content );
    return $content;
}
add_filter('the_content', 'remove_empty_p', 20, 1);

// Custom cart ajax
add_action( 'wp_ajax_sinus_add', 'sinus_cart_add' );
add_action( 'wp_ajax_nopriv_sinus_add', 'sinus_cart_add' );
add_action( 'wp_ajax_sinus_remove', 'sinus_cart_remove' );
add_action( 'wp_ajax_nopriv_sinus_remove', 'sinus_cart_remove' );
add_action( 'wp_ajax_sinus_getsinglehtml', 'sinus_get_single_html' );
add_action( 'wp_ajax_nopriv_sinus_getsinglehtml', 'sinus_get_single_html' );

// Get Woocommerce API
add_action( 'wp_ajax_sinus_products', 'sinus_get_products' );
add_action( 'wp_ajax_nopriv_sinus_products', 'sinus_get_products' );
add_action( 'wp_ajax_sinus_brand', 'sinus_get_products_by_brand' );
add_action( 'wp_ajax_nopriv_sinus_brand', 'sinus_get_products_by_brand' );
add_action( 'wp_ajax_sinus_type', 'sinus_get_products_by_type' );
add_action( 'wp_ajax_nopriv_sinus_type', 'sinus_get_products_by_type' );


function sinus_get_single_html() {
  $decoded = json_decode(file_get_contents("php://input"));
  $id = intval($decoded->id);

  $args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'p' => $id );
  $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
    ob_start(); ?>
    <?php wc_get_template_part('content', 'single-product'); ?>

  <?php
    $content = ob_get_contents();
    endwhile;

    ob_end_clean();
    wp_reset_postdata();

  echo $content;
  wp_die();
}


$fields = "id,title,categories,tags,regular_price,sale_price,price_html,featured_src,images,description,permalink,stock_quantity,visible";

function sinus_get_products() {
  global $client, $fields;
  $decoded = json_decode(file_get_contents("php://input"));
  $offset = $decoded->offset;
  $limit = $decoded->limit;

  if ( false === ( $sinus_all_query = get_transient( 'sinus_all_query' ) ) ) {
      $products = $client->products->get(null,
      array(
        'filter[limit]'   => -1,
        'filter[offset]'  => 0,
        'fields'          => $fields,
        )
      );
       set_transient( 'sinus_all_query', $products, 24 * HOUR_IN_SECONDS );
  } else {
    $products = get_transient( 'sinus_all_query' );
  }

  echo json_encode($products);
  wp_die();
}

function sinus_get_products_by_brand() {
  global $client, $fields;
  $decoded = json_decode(file_get_contents("php://input"));
  $brand = $decoded->param;
  $offset = $decoded->offset;
  $limit = $decoded->limit;

  if ( !$offset ) {
    $offset = 0;
  }

  $products = $client->products->get(null,
      array(
        'filter[tag]'     => $brand,
        'filter[limit]'   => $limit,
        'filter[offset]'  => $offset,
        'fields'          => $fields,
      )
    );

  echo json_encode($products);
  wp_die();
}

function sinus_get_products_by_type() {
  global $client, $fields;
  $decoded = json_decode(file_get_contents("php://input"));
  $type = $decoded->param;
  $offset = $decoded->offset;
  $limit = $decoded->limit;

  if ( !$offset ) {
    $offset = 0;
  }

  $products = $client->products->get(null,
      array(
        'filter[category]'  => $type,
        'filter[limit]'     => -1,
        'filter[offset]'    => $offset,
        'fields'            => $fields,
      )
    );

  echo json_encode($products);
  wp_die();

  // $url = "inc/type_hovedtelefoner.json";
  // $get_file = json_decode(file_get_contents("inc/type_hovedtelefoner.json"));

  // echo $get_file;
  // // echo json_encode($get_file);
  // wp_die();
}



// set customer cookies on initialization
function set_init_cookie() {
  if ( is_user_logged_in() || is_admin() ) {
    return;
  } else {
    global $woocommerce;
    WC()->session->set_customer_session_cookie(true);
  }
}
add_action('init', 'set_init_cookie');

function sinus_cart_add() {
  $decoded = json_decode(file_get_contents("php://input"));

  WC()->cart->add_to_cart( $decoded->product_id, 1 );

  WC()->cart->persistent_cart_update();
  $get_updated_cart = cart_update();
  echo $get_updated_cart;
  wp_die();
}

function sinus_cart_remove() {
  $decoded = json_decode(file_get_contents("php://input"));
  $remove_id = $decoded->product_id;
  $qty = $decoded->quantity;
  $cart = WC()->cart->get_cart();

  foreach ( $cart as $cart_item_key => $cart_item ) {
    $prod_id = $cart_item['product_id'];

    if( $remove_id == $prod_id ) {
      WC()->cart->set_quantity( $cart_item_key, $cart_item['quantity'] - $qty, true  );
      break;
    }
  }

  WC()->cart->persistent_cart_update();
  $get_updated_cart = cart_update();
  echo $get_updated_cart;
  wp_die();
}

function cart_update() {
  $qty = WC()->cart->get_cart_contents_count();
  $total = WC()->cart->get_cart_total();
  $cart_url = WC()->cart->get_cart_url();
  $checkout_url = WC()->cart->get_checkout_url();
  $cart = WC()->cart->get_cart();

  // generate output to update the cart.
  ob_start();
  ?>

     <?php if ( $qty < 1 ) { ?>
        <div class="cart-empty"><h4 class="cart">Din kurv er tom...</h4></div>
      <?php } ?>

      <?php if ( $qty >= 1 ) { ?>

        <div class="cart-container">
          <div class="cart-count"><p class="small">Antal varer: <?php echo $qty; ?></p></div>

          <?php foreach ($cart as $ca) { ?>
          <?php
            $product = new WC_Product( $ca['product_id'] );
            $price = $product->price;
          ?>
            <div class="cart-element" data-id="<?php echo $ca['product_id']; ?>">
              <div class="remove-icon"><p>X</p></div>
              <div class="elem-title"><p><?php echo get_the_title($ca['product_id']); ?></p></div>
              <div class="elem-qty-total"><p>
              <?php
              if ( $ca['quantity'] > 1 ) {
                echo $ca['quantity'] . ' x ' . $price . ',- kr.';
              } else {
                echo $price . ',- kr.';
              } ?>
              </p></div>
            </div>

          <?php } ?>

          <div class="cart-total">
            <p class="small">I alt: </p><h4><?php echo $total; ?></h4>
            <p class="small">(inkl. moms)</p>
          </div>

          <div class="cart-link first"><a class="cart" href="/reserver">Reserver</a></div>
          <div class="cart-link second"><a class="cart" href="<?php echo $cart_url; ?>">Kurv</a></div>
          <div class="cart-link third"><a class="cart" href="<?php echo $checkout_url; ?>">Check ud</a></div>

        </div>
      <?php } ?>

  <?php
  $cart_content = ob_get_clean();
  return $cart_content;
}

function get_stripped_cart() {
  $qty = WC()->cart->get_cart_contents_count();
  $total = WC()->cart->get_cart_total();
  $cart_url = WC()->cart->get_cart_url();
  $checkout_url = WC()->cart->get_checkout_url();
  $cart = WC()->cart->get_cart();

  ob_start();
  ?>
      <h4>Antal varer: <?php echo $qty; ?></h4>
      <?php foreach ($cart as $ca) {
        $product = new WC_Product( $ca['product_id'] );
        $price = $product->price;
      ?>
        <h2><?php echo get_the_title($ca['product_id']); ?></h2>
        <p>
          <?php
          if ( $ca['quantity'] > 1 ) {
            echo $ca['quantity'] . ' x ' . $price . ',- kr.';
          } else {
            echo $price . ',- kr.';
          } ?>
          </p>
      <?php } ?>
      <br>
        <p>I alt: </p><h4><?php echo $total; ?></h4>
        <p>(inkl. moms)</p>
  <?php
  $cart_stripped = ob_get_clean();
  return $cart_stripped;
}


function reserve_in_store() {
  $customer = json_decode(file_get_contents("php://input"));
  $cart_data = get_stripped_cart();

  if ( isset($customer) ) {
    $sanitized_email = filter_var($customer->customer_email, FILTER_SANITIZE_EMAIL);
    $headers = array(
      'From: Sinus - sinus-store.dk <info@sinus-store.dk>',
      'Content-Type: text/html; charset=UTF-8'
    );

    // Add company logo
    $file = get_template_directory_uri() . '/img/sinus_logo_new3.png';
    $uid = 'logo-uid'; //will map it to this UID
    $name = 'sinus_store_logo.png';

    global $phpmailer;
    add_action( 'phpmailer_init', function(&$phpmailer)use($file,$uid,$name){
      $phpmailer->SMTPKeepAlive = true;
      $phpmailer->AddEmbeddedImage($file, $uid, $name);
    });

    $image_path = '<img src="' . get_template_directory_uri() . '/img/sinus_logo_new3.png' . '" width="203" height="62" alt="Sinus Store Logo">';
    $company_info = '<br><h2>Sinus-Store.dk // Sinus IVS</h2><h4>Studiestræde 24, kld. th.<br>DK-1455<br>København K<br>Danmark<br><br>Email: info@sinus-store.dk<br>Tlf: (+45) 61458215</h4>';

    $email_body = '<html><head></head><body>';
    $email_body .= '<h2>Tak for din bestilling!</h2><p>Vi lægger de valgte varer til side til dig hurtigst muligt, og kontakter dig lige så snart de er klar til afhentning. Vi reserverer kun varer i to dage, så kontakt os, hvis du ønsker at afhente varen senere.' . $cart_data . '<br>Med venlig hilsen</p>' . $image_path . $company_info;
    $email_body .= '</body></html>';

    $customer_subject = 'sinus-store.dk - Tak for din reservation.';
    $customer_body = $email_body;

    $company_to = 'orders@sinus-store.dk';
    $company_subject = 'Lægges til side i butik!';
    $company_body = '<h2>Lægges til side i butik!</h2><p>Kundeinformation:<br>' . $customer->customer_html . '<p>Varer:</p><br>' . $cart_data . '</p>';

    wp_mail($sanitized_email, $customer_subject, $customer_body, $headers);
    wp_mail($company_to, $company_subject, $company_body, $headers);

    echo "Success";
    WC()->cart->empty_cart();
    WC()->cart->persistent_cart_destroy();
    wp_die();
  } else {
    echo "Error";
    wp_die();
  }
}

add_action( 'wp_ajax_reserve', 'reserve_in_store' );
add_action( 'wp_ajax_nopriv_reserve', 'reserve_in_store' );
?>
