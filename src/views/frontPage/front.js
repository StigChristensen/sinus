// VENDOR
// if jQuery isn't already loaded, require jQuery
// if ( !window.jQuery || !window.$ ) {
//   window.jQuery = window.$ = require('../../node_modules/jquery/dist/jquery.min.js');
// }

// import jQuery from 'jquery';
import velocity from 'velocity-animate';
import AnimationController from './components/animationController.js';
import sortController from './components/sortController.js';
import cartController from './components/cartController.js';
// import menuController from './components/menuController.js';
const $ = jQuery;

jQuery(document).on('ready', function() {
  // menuController.menuController();
  AnimationController.animateIn();
  AnimationController.menuControllerFixed();
  cartController.addToCartController();
  cartController.removeFromCartController();

});
