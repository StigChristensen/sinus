// VENDOR
// if jQuery isn't already loaded, require jQuery
if ( !window.jQuery || !window.$ ) {
  window.jQuery = window.$ = require('../../node_modules/jquery/dist/jquery.min.js');
}

import AnimationController from './components/animationController.js';


jQuery(document).on('ready', function() {
  AnimationController.animateIn();
  AnimationController.menuControllerFixed();
});


