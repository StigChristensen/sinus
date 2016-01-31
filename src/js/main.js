// Test if ie10 - adds class "ie10" to HTML tag, if true. - Excludes IE11
if (/*@cc_on!@*/false && document.documentMode === 10) {
    document.documentElement.className+=' ie10';
}

jQuery(document).on('ready', function() {
  $ = jQuery;

  new SineAnimation();
  new CartController();
  new MenuController();
  new gridCartController();
  new embedVidController();

  // labels for input fields
  $("form :input").focus(function() {
    $("label[for='" + this.id + "']").addClass("focus");
  }).blur(function() {
    $("label").removeClass("focus");
  });
}); // End Ready


var embedVidController = function() {
  var vidFrame = $('body').find('.youtube-frame');

  if ( vidFrame.length > 0 ) {
    initVideo();
  } else {
    return;
  }

  function initVideo() {
    var vidUrl = $(vidFrame).attr('data-href'),
        vidId = vidUrl.split('/'),
        constructedHtml = '<iframe width="760" height="428" src="https://www.youtube.com/embed/' + vidId[3] + '?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';

    $(vidFrame).html(constructedHtml);
  }
};


var gridCartController = function() {
  var addBtn = $('body').find('.add-button');

  $(addBtn).each(function(i, e) {
    var productHref = $(this).attr('data-href'),
        curLocation = window.location.href;

    $(this).on('click', function(event) {
      event.preventDefault();
      var url = curLocation + productHref;

      console.log(url, this);

      $.get({
        url: url,
        success: function(response) {
          console.log('success -', response);
        },
        error: function(response) {
          console.log('error -', response);
        }
      });
    });
  });
};


var MenuController = function() {
  var menuBtn = $('body').find('.menu-icon'),
      mainMenu = $('body').find('.main-menu'),
      menuLinks = $(mainMenu).find('li'),
      menuHeaders = $(mainMenu).find('h3'),
      footer = $('body').find('footer'),
      footerPosition = $(footer).position();

      // set menu height, relative to content height
      $(mainMenu).css({
        'height': footerPosition.top + 100 + 'px'
      });

      $(menuBtn).on('click', function() {
        if ( $(mainMenu).hasClass('hidden') ) {
          $(mainMenu).removeClass('hidden');
          $(this).addClass('open');
          addEventListener();
        } else {
          $(mainMenu).addClass('hidden');
          $(this).removeClass('open');
        }
      });

      function addEventListener() {
        $(menuLinks).on('click', function(e) {
          e.preventDefault();
          var aHref =  $(this).find('a');
          var href = $(aHref).attr('href');

          $(menuLinks).each(function(i, elem) {
            var delay = i * 50;

            $(elem).velocity({
              'opacity': [0, 1]
            }, {duration: 200, delay: delay, easing: 'easeInOutSine'});

          });

          $(menuHeaders).each(function(i, elem) {
            var delay = i * 100;

            $(elem).velocity({
              'opacity': [0, 1]
            }, {duration: 250, delay: delay, easing: 'easeInOutSine'});
          });

          setTimeout(navigate(href), 1200);
        });
      }

      function navigate(href) {
        setTimeout(function() {
          $(menuBtn).removeClass('open');
          $(mainMenu).addClass('hidden');
        }, 900);

        setTimeout(function() {
          window.location.href = href;
        }, 1300);
      }
};


var CartController = function() {
  var cartIcon = $('body').find('.cart-icon'),
      cartContents = $('body').find('.cart-contents');

  $(cartIcon).on('click', function(e) {
    $(cartContents).toggleClass('hidden');
  });
}

var SineAnimation = function() {
  var container = $('body').find('.sine-animation'),
      imgContainer = $(container).find('.img-container');

      var options = {
        'duration': 5000,
        'delay': 8000,
        'easing': 'easeInOutSine',
        'loop': true
      }

      $(imgContainer).velocity({
        'left': [-310, 0]
      }, options);
};
