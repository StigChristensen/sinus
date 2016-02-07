// VENDOR
// if jQuery isn't already loaded, require jQuery - makes ajax easier.
if ( !window.jQuery || !window.$ ) {
  window.jQuery = window.$ = require('../../node_modules/jquery/dist/jquery.min.js');
}

// MODULES
let userInfo = require('./components/userInfo.js');
let userFeed = require('./components/userFeed.js');

new userInfo();
new userFeed();

