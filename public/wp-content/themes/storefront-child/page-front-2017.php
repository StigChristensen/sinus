<?php
/**
 * Template Name: Frontpage 2017
 */

get_header(); ?>

<div class="scroll-indicator hidden">
  <i class="fa fa-angle-down first"></i>
  <i class="fa fa-angle-down second"></i>
</div>

<?php
global $post;
$args = array( 'taxonomy' => 'product_cat');
$terms = wp_get_post_terms($post->ID,'product_cat', $args);
?>


<div class="fp-wrap">
  <div class="fp-content-wrap">

    <div class="fp-content-row fixed black">

    <div class="fp-slider-container">
      <div class="banners-container">
        <div class="nextprev">
          <div class="prev-btn">
            <i class="fa fa-caret-left" aria-hidden="true"></i>
          </div>
          <div class="next-btn">
            <i class="fa fa-caret-right" aria-hidden="true"></i>
          </div>
        </div>

      <?php $args = array( 'post_type' => 'banner', 'posts_per_page' => -1 );
            $loop = new WP_Query( $args );

            $index = 1;

            while ( $loop->have_posts() ) : $loop->the_post();

            $should_show = get_field('showing');

              if ($should_show):
                if ($index == 1):
                  $class = 'active';
                else:
                  $class = 'hidden';
                endif;
                ?>

            <div class="banner-element element-<?php echo $index; ?> <?php echo $class; ?>" data-index="<?php echo $index; ?>">
              <a href="<?php the_field('banner_link'); ?>" target="_parent">
                <img src="<?php the_field('banner_image'); ?>" alt="Sinus Store Headphones and Audio Front Page Banner"/>
              </a>
            </div>

            <?php $index++; ?>

            <?php endif; ?>

          <?php endwhile; ?>
      </div>
    </div>

    <div class="fp-aboutus">
      <h4>Sinus</h4><span> er Danmarks mest specialiserede forretning indenfor hovedtelefoner og transportabel lyd.
      Vi har i takt med den teknologiske udvikling nået et punkt hvor hovedparten af den musik vi hører i løbet af en dag, lyttes til igennem vores hovedtelefoner. Og vi mener at musikken i dit liv fortjener god lyd.<br><br>
  Men hovedtelefoner er ikke bare den gode lyd til dit livs soundtrack. Hovedtelefoner er mode, hovedtelefoner er frihed fra omverdenens støj, hovedtelefoner er in-ear, on-ear, over-ear, med eller uden bluetooth og vigtigst af alt hovedtelefoner skal matche dig og dine behov – og det kan og vil vi hjælpe med.
      </span>
    </div>
  </div>


  <div class="fp-content-row fixed icons">
    <a href="/type/hovedtelefoner/overear"><div class="brand-circle icon" style="background: url('<?php echo get_stylesheet_directory_uri() . '/img/overear_bg.png'; ?>'); background-size: cover; background-position: left;">
      <span>Over-Ear</span>
    </div></a>

    <a href="/type/hovedtelefoner/onear"><div class="brand-circle icon" style="background: url('<?php echo get_stylesheet_directory_uri() . '/img/onear_bg.png'; ?>'); background-size: cover; background-position: left;">
      <span>On-Ear</span>
    </div></a>

    <a href="/type/hovedtelefoner/inear"><div class="brand-circle icon" style="background: url('<?php echo get_stylesheet_directory_uri() . '/img/inear_bg.png'; ?>'); background-size: cover; background-position: left;">
      <span>In-Ear</span>
    </div></a>
  </div>


  <!-- T0p 10 -->

  <?php
    global $post;
    $posts = get_field('top_ten');

    var_dump($posts);

    if ( $posts ): ?>
    <div class="fp-content-row black">
      <ul class="products list">
        <?php foreach ($posts as $p ) { ?>
          <?php wc_get_template_part('content', 'single-product-list'); ?>
    <?php }
       ?>
      </ul>
    </div>
    <?php endif; ?>


  <!-- Store info -->

  <div class="fp-content-row black">
    <!-- <a href="https://goo.gl/maps/7JA3Pw2xbw72" target="_blank"><div class="info-left" style="background: url('<?php echo get_stylesheet_directory_uri() . '/img/map1.png'; ?>'); background-size: cover; background-position: left;"></div></a> -->

    <div class="info-left">
      <div class="mapcover"></div>
      <div class="largemap" id="largemap"></div>
    </div>

    <div class="info-right">
      <div class="brand-circle reversed info">
        <span>Butikken</span>
      </div>

      <div class="info-store-address">
        <span>Studiestræde 24, kld-th.</span><br>
        <span>DK-1455 København K</span><br>
        <span>TLF: <a href="tel:+4561458215">(+45) 61 45 82 15</a></span><br>
        <span>MAIL: <a href="mailto:info@sinus-store.dk">info@sinus-store.dk</a></span>

      </div>
      <div class="opening-hours">
        <h4>Åbningstider</h4>
        <div class="open-left">
            <span>Man:</span><br>
            <span>Tir:</span><br>
            <span>Ons:</span><br>
            <span>Tor:</span><br>
            <span>Fre:</span><br>
            <span>Lør:</span><br>
            <span>Søn:</span>
        </div>
        <div class="open-right">
            <span>11-18</span><br>
            <span>11-18</span><br>
            <span>11-18</span><br>
            <span>11-18</span><br>
            <span>11-18</span><br>
            <span>11-15</span><br>
            <span>Lukket</span>

        </div>
      </div>
    </div>
  </div>

  <!-- Brands -->

  <div class="fp-content-row black">
    <div class="brands-left">
      <div class="brand-circle reversed">
        <span>Brands</span>
      </div>

      <div class="brands-desc">
        <span>Brands vi forhandler. Både i butikken i <br>Studiestræde og i webshoppen.</span>
      </div>

    </div>

    <div class="brands-right">
      <ul class="brands-list">
      <?php
        $args = array(
          'orderby'      => 'name',
          'order'        => 'ASC',
          'hide_empty'   => 1
        );

        $tags = get_terms('product_tag', $args);

        foreach( $tags as $tag ) {
          $brands[] = $tag->name;
        }

        natcasesort($brands);

        foreach( $brands as $brand ) { ?>
          <li class="brand"><a href="<?php echo '/brands/' . str_replace(" ", "-", $brand); ?>"><?php echo $brand; ?></a></li>

        <?php } ?>

      </ul>
    </div>
  </div>

  <!-- Articles -->

  <div class="fp-content-row black">
    <div class="brand-circle articles">
      <span>Nyheder</span>
    </div>


      <ul class="articles front">
        <?php $args = array( 'post_type' => 'article', 'posts_per_page' => -1, 'post_status' => 'publish' );
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post(); ?>
              <li class="article list animate">
                <a href="<?php the_permalink(); ?>">
                  <div class="image-container">
                    <?php
                      $img = get_field('article_image');
                      if ( $img ) {
                    ?>
                      <img src="<?php the_field('article_image'); ?>" alt="Sinus Copenhagen Sinus-Store - <?php the_title(); ?>">

                    <?php } ?>

                    <div class="article-info">
                      <?php the_date('d/m/Y'); ?>
                    </div>
                  </div>
                  <div class="article-excerpt">
                    <span class="article-title"><?php the_title(); ?></span>
                    <div class="article-content">
                      <?php
                      echo wp_trim_words( get_field('article_content'), 60, '... Læs mere');
                      ?>
                      <i class="fa fa-caret-right" aria-hidden="true"></i>
                    </div>
                  </div>
                </a>
              </li>

      <?php endwhile; ?>
        </ul>

      </div>
    </div>
  </div>

<?php get_footer(); ?>

<script>
function largeMap() {
  map = new google.maps.Map(document.getElementById('largemap'), {
    center: latLng,
    zoom: 16,
    styles: mapStyle
  });

  var marker = new google.maps.Marker({
    position: latLng,
    map: map,
    title: 'Sinus | Headphones & Audio'
  });
}
</script>
