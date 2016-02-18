<?php
/**
 * The template for displaying the search form.
 */
?>

<form class="search" action="/" method="get">
    <label for="search" class="search-label"><img class="black" src="<?php echo get_stylesheet_directory_uri() . '/img/searchicon_white.png'; ?>" alt="search sinus-store.dk icon"/></label>
    <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder=""/>
    <input type="hidden" value="product" name="post_type" id="post_type" />
    <input type="submit" id="sub-search" class="search-submit" value="<?php echo esc_attr_x( 'Søg', 'submit button' ) ?>" />
</form>


<?php

?>
