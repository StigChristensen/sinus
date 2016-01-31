<?php
/**
 * The template for displaying the search form.
 */
?>

<form class="search" action="/" method="get">
  <div class="flex-container">
    <label for="search" class="search-label"><img src="<?php echo get_stylesheet_directory_uri() . '/img/searchicon.png'; ?>" alt="search sinus-store.dk icon"/></label>
    <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="Søg..."/>
    <input type="hidden" value="product" name="post_type" id="post_type" />
    <input type="submit" id="sub-search" class="search-submit" value="<?php echo esc_attr_x( 'Søg', 'submit button' ) ?>" />
    <div class="underline"></div>
  </div>
</form>


<?php

?>
