import velocity from 'velocity-animate';
const $ = jQuery;

module.exports = {
  MenuController: function() {
    var menuBtn = $('body').find('.menu-icon'),
        mainMenu = $('body').find('.main-menu'),
        menuLinks = $(mainMenu).find('li'),
        menuHeaders = $(mainMenu).find('h3'),
        searchForm = $('body').find('.search-form'),
        cartIcon = $('body').find('.cart-icon'),
        cartContents = $('body').find('.cart-modal.cart-contents'),
        width = $(window).width();
        setMenuHeight();

        $(menuBtn).on('click', animateMenu);

        function animateMenu() {
          if ( $(mainMenu).hasClass('hidden') ) {
            $(mainMenu).css({
              'display': 'block'
            });
            setTimeout(function() {
              $(mainMenu).removeClass('hidden');
              $(this).addClass('open');
              scrollTo('0px');
              addEventListener();
              if ( width > 767 ) {
                updateHeaderOpen();
              }

            }, 100);

          } else {
            $(mainMenu).addClass('hidden');
            $(this).removeClass('open');
            if ( width > 767 ) {
                updateHeaderClose();
              }

            setTimeout(function() {
              $(mainMenu).css({
                'display': 'none'
              }, 700);
            });
          }
        }

        function updateHeaderOpen() {
          var rawIconCss = $(cartIcon).css('right'),
              rawSearchCss = $(searchForm).css('right'),
              rawCartContCss = $(cartContents).css('right'),
              iconRight = parseInt(rawIconCss.replace('px', '')),
              searchRight = parseInt(rawSearchCss.replace('px', '')),
              cartContRight = parseInt(rawCartContCss.replace('px', ''));

              $(cartIcon).velocity({
                'right': iconRight + 230 + 'px'
              }, {duration: 400, delay: 100, easing: [.24,.63,.5,.99]});

              $(searchForm).velocity({
                'right': searchRight + 230 + 'px'
              }, {duration: 400, delay: 0, easing: [.24,.63,.5,.99]});

              $(cartContents).velocity({
                'right': cartContRight + 230 + 'px'
              }, {duration: 400, delay: 150, easing: [.24,.63,.5,.99]});
        }

        function updateHeaderClose() {
              $(cartIcon).velocity({
                'right': 90
              }, {duration: 300, delay: 200, easing: [.24,.63,.5,.99]});

              $(searchForm).velocity({
                'right': 165
              }, {duration: 300, delay: 300, easing: [.24,.63,.5,.99]});

              $(cartContents).velocity({
                'right': 80
              }, {duration: 300, delay: 250, easing: [.24,.63,.5,.99]});
        }

        function addEventListener() {
          $(menuLinks).on('click', function(e) {
            e.preventDefault();
            var aHref =  $(this).find('a');
            var href = $(aHref).attr('href');

            $(menuLinks).each(function(i, elem) {
              var delay = i * 20;

              $(elem).velocity({
                'opacity': [0, 1]
              }, {duration: 100, delay: delay, easing: 'easeInOutSine'});

            });

            $(menuHeaders).each(function(i, elem) {
              var delay = i * 30;

              $(elem).velocity({
                'opacity': [0, 1]
              }, {duration: 100, delay: delay, easing: 'easeInOutSine'});
            });

            setTimeout(navigate(href), 1200);
          });
        }

        function navigate(href) {
          setTimeout(function() {
            $(menuBtn).removeClass('open');
            $(mainMenu).addClass('hidden');
            updateHeaderClose();
          }, 1000);

          setTimeout(function() {
            window.location.href = href;
          }, 1300);
        }
  };
}
