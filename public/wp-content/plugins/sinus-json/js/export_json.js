jQuery(document).on('ready', function() {
  var $ = jQuery;

  var exportBtn = $('body').find('a.export-btn'),
      spin = $('body').find('.export-spin'),
      link = $('body').find('.output');

  $(exportBtn).on('click', function(e) {
    e.preventDefault();

    $(spin).show();

    var url = exp.export_url + '?action=export_json';

    $.ajax({
      url: url,
      type: "GET",
      dataType: 'json',
      success: function(response) {
        $(spin).hide();

        // console.log(response);

        $(link).html(response);
      },
      error: function(response) {
        console.log(response);
        $(spin).hide();
      }
    });
  });

});
