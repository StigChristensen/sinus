// VENDOR
// if jQuery isn't already loaded, require jQuery
if ( !window.jQuery || !window.$ ) {
  window.jQuery = window.$ = require('../../node_modules/jquery/dist/jquery.min.js');
}

import velocity from 'velocity-animate';
import AnimationController from './components/animationController.js';
import sortController from './components/sortController.js';
const $ = jQuery;

jQuery(document).on('ready', function() {
  AnimationController.animateIn();
  AnimationController.menuControllerFixed();
  sortController.sortStockController();
});

