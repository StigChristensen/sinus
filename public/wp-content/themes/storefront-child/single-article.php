<?php
/**
 * Template Name: Single Article
 */

get_header(); ?>

<div class="article container">

  <div class="article headline-wrap">
    <div class="article headline">
      <h1><?php the_title(); ?></h1>
    </div>
  </div>

    <div class="content-container">
      <?php the_field('article_content'); ?>
    </div>


    <?php if( have_rows('article_products') ): ?>

    <div class="article-products">

        <?php while ( have_rows('article_products') ) : the_row(); ?>

          <div class="article-product">
            <a href="<?php the_sub_field('article_product_link'); ?>">
              <div class="article-product-image">
                <img src="<?php the_sub_field('article_product_image'); ?>" alt="<?php the_sub_field('article_product_name'); ?>">
              </div>

              <div class="savings">
                <span class="savetext">Du Sparer:</span>
                <span class="save-amount"><?php the_sub_field('article_product_savings'); ?>,- Kr.</span>
              </div>

              <div class="article-product-info">
                <div class="article-product-name">
                  <h4><?php the_sub_field('article_product_name'); ?></h4>
                </div>

                <div class="reg-price">
                  <span class="reg">Normal Pris:</span>
                  <span class="reg-amount"><?php the_sub_field('article_product_price'); ?>,- Kr.</span>
                </div>
                <div class="sale-price">
                  <span class="sale-text">Tilbudspris:</span>
                  <span class="sale-amount"><?php the_sub_field('article_product_price_sale'); ?>,- Kr.</span>
                </div>
              </div>

            </a>
          </div>

        <?php endwhile; ?>

    </div>

  <?php endif; ?>

</div>


<?php get_footer(); ?>
