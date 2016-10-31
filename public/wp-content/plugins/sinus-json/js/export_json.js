jQuery(document).on('ready', function() {
  var $ = jQuery;

  var exportBtn = $('body').find('a.exportjson-btn'),
      spin = $('body').find('.exportjson-spin'),
      link = $('body').find('.outputjson');

  $(exportBtn).on('click', function(e) {
    e.preventDefault();

    console.log('click');

    $(spin).show();

    var url = exp.export_url + '?action=export_json';

    $.ajax({
      url: url,
      type: "GET",
      dataType: 'json',
      success: function(response) {
        $(spin).hide();

        console.log(JSON.stringify(response));

        $(link).html(response);
      },
      error: function(response) {
        console.log('Error: ' + JSON.stringify(response));
        $(spin).hide();
      }
    });
  });

});
