jQuery(document).on('ready', function() {
  var $ = jQuery;

  var exportBtn = $('body').find('a.export-btn'),
      spin = $('body').find('.export-spin'),
      link = $('body').find('.link');

  $(exportBtn).on('click', function(e) {
    e.preventDefault();

    $(spin).show();

    var url = exp.export_url + '?action=export_products';

    $.ajax({
      url: url,
      type: "GET",
      dataType: 'json',
      success: function(response) {
        $(spin).hide();

        var split = response.split('/wp-content/'),
            url = exp.site + '/wp-content/' + split[1],
            returned = '<a href="' + url + '">SINUS_PRODUCTS_.CSV</a>';

        $(link).html(returned);
      },
      error: function(response) {
        console.log('response');
        $(spin).hide();
      }
    });
  });

});
