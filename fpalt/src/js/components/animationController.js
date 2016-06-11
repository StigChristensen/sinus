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
          menuLeft = $('body').find('.menu-left');

      if ( scroll >= 852 ) {
        if ( $(menuLeft).hasClass('fixed') ) {
          return;
        } else {
          $(menuLeft).addClass('fixed');
        }
      }

      if ( scroll < 852 ) {
        if ( !$(menuLeft).hasClass('fixed') ) {
          return;
        } else {
          $(menuLeft).removeClass('fixed');
        }
      }
    });
  }
}

