jQuery(document).on('ready', function() {
  var $ = jQuery;

  var exportBtn = $('body').find('a.export-btn');

  $(exportBtn).on('click', function(e) {
    e.preventDefault();

    var url = exp.export_url + '?action=export_products';

    $.ajax({
      url: url,
      type: "POST",
      dataType: 'json',
      success: function(response) {
        console.log(response);
        var href = window.location.href;
        window.location.href = href + '?exported=true';
      },
      error: function(response) {
        console.log(response);
      }
    });
  });

});
