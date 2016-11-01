const $ = jQuery;

module.exports = {
  scrollListener: function() {
    let subMenu = $('body').find('.header-link-row');

    $(window).scroll(() => {
      let scrollAmount = window.pageYOffset || document.documentElement.scrollTop;

      if ( scrollAmount > 600 ) {
        $(subMenu).addClass('hidden');
      }

      if ( scrollAmount < 600 ) {
        $(subMenu).removeClass('hidden');
      }
    });
  }
}
