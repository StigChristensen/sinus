<?php

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
	wp_enqueue_script( 'vendor', get_stylesheet_directory_uri() . '/js/lib.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'app', get_stylesheet_directory_uri() . '/js/main.min.js', array( 'vendor' ), '0.0.1', true );

  wp_localize_script('app', 'site', array( 'theme_path' => get_stylesheet_directory_uri(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'site_url' => get_site_url() ));

	wp_enqueue_style( 'main', get_stylesheet_directory_uri() . '/css/main.min.css', array(), '0.0.1' );
}
add_action( 'wp_enqueue_scripts', 'reg_scripts', 10 );



// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'wd_flush_rewrite_rules' );

// Flush your rewrite rules
function wd_flush_rewrite_rules() {
  flush_rewrite_rules();
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

function sinus_cart_add() {

  $decoded = json_decode(file_get_contents("php://input"));

  if ( $decoded ) {
    WC()->cart->add_to_cart( $decoded->product_id, 1 );
  } else {
    return false;
  }

  $qty = WC()->cart->get_cart_contents_count();
  $total = WC()->cart->get_cart_total();
  $cart_url = WC()->cart->get_cart_url();
  $checkout_url = WC()->cart->get_checkout_url();
  $cart = WC()->cart->get_cart();

  // generate output to update the cart.
  ob_start();
  ?>

    <div class="arrow-up">
      <img src="<?php echo get_stylesheet_directory_uri() . '/img/arrowup.png'; ?>">
    </div>

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
            <div class="cart-element">
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

          <div class="cart-link first"><a class="cart" href="<?php echo $cart_url; ?>">Kurv</a></div>
          <div class="cart-link second"><a class="cart" href="<?php echo $checkout_url; ?>">Check ud</a></div>

        </div>
      <?php } ?>

  <?php
  $cart_content = ob_get_clean();
  echo $cart_content;
}



?>
