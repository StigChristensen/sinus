import velocity from 'velocity-animate';
const $ = jQuery;

module.exports = {
  animateIn: ()=> {
    let animateObjects = $('body').find('.animate');

    $(animateObjects).each(function(i,e) {
      let delay = 100 * i;

      $(e).velocity({
        'opacity': 1,
        'margin-top': 0
      }, {duration: 500, delay: delay, easing: [.24,.63,.5,.99]});
    });
  },

  menuControllerFixed: ()=> {
    $(window).on('scroll', function() {
      let scroll = $(window).scrollTop(),
          curWidth = $(window).width(),
          menuLeft = $('body').find('.menu-left'),
          limit;

      if ( curWidth >= 900 ) {
        limit = 972;
        setClass(limit);
      }

      if ( curWidth <= 899 && curWidth >= 769 ) {
        limit = 1330;
        setClass(limit);
      }

      function setClass(limit) {
        if ( scroll >= limit ) {
          if ( $(menuLeft).hasClass('fixed') ) {
            return;
          } else {
            $(menuLeft).addClass('fixed');
          }
        }

        if ( scroll < limit ) {
          if ( !$(menuLeft).hasClass('fixed') ) {
            return;
          } else {
            $(menuLeft).removeClass('fixed');
          }
        }
      }
    });
  }
}
