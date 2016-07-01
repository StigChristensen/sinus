const $ = jQuery || window.jQuery;

$(document).on('ready', function() {
  $.ajax
  ({
    type: "GET",
    url: "https://www.sinus-store.dk/wp-json/posts?type=product&filter[product_cat]=inear&filter[product_cat]=studie&page=2",
    dataType: 'json',
    success: function(response){
      console.log('Response: - ' + JSON.stringify(response));
    },
    error: function(response) {
      console.log('Error: - ' + JSON.stringify(response));
    }
  });
});
