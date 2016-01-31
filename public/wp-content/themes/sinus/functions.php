<?php

if ( ! function_exists( 'wd_setup' ) ) :
function wd_setup() {
	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails', array( 'post' ) );

  show_admin_bar(false);
}
endif;
add_action( 'after_setup_theme', 'wd_setup' );



function my_acf_show_admin( $show ) {
    return current_user_can('manage_options');
}
add_filter('acf/settings/show_admin', 'my_acf_show_admin');


// Remove unwanted Menu Items in Admin.
function remove_menus(){
  remove_menu_page( 'edit.php' );                   //Posts
  // remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
}
add_action( 'admin_menu', 'remove_menus' );


function reg_scripts() {

	wp_enqueue_script( 'angular', get_template_directory_uri() . '/js/lib.js', array(), '1.4.5', true );
	wp_enqueue_script( 'app', get_template_directory_uri() . '/js/main.min.js', array( 'angular' ), '0.1.0', true );
	wp_localize_script('app', 'site', array( 'theme_path' => get_stylesheet_directory_uri() ));
	wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.css', array(), '0.1.0' );
}

add_action( 'wp_enqueue_scripts', 'reg_scripts' );

?>
