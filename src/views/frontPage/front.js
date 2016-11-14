import velocity from 'velocity-animate';
import cartController from './components/cartController.js';
import menuController from './components/menuController.js';
import subMenuScroll from './components/subMenuScroll.js';
import fpSlider from './components/fpSlider.js';
const $ = jQuery;

jQuery(document).on('ready', function() {
  cartController.toggleCart();
  cartController.addToCartController();
  cartController.removeFromCartController();
  menuController.MenuController();
  fpSlider.initialize();
  subMenuScroll.scrollListener();

  let mapCover = $('body').find('.mapcover');

  if ( mapCover.length > 0 ) {
    $(mapCover).on('click', function() {
      $(this).css({
        'display': 'none'
      });
    });
  }

});
