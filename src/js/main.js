// Test if ie10 - adds class "ie10" to HTML tag, if true. - Excludes IE11
if (/*@cc_on!@*/false && document.documentMode === 10) {
    document.documentElement.className+=' ie10';
}

jQuery(document).on('ready', function() {
  $ = jQuery;

  new CartController();
  new MenuController();
  new gridCartController();
  new embedVidController();
  new productTextController();
  new singleProductHeightController();
  new removeFromCartController();
  new reserveFormController();
  new scrollHeaderController();

  // labels for input fields
  $("form :input").focus(function() {
    $("label[for='" + this.id + "']").addClass("focus");
  }).blur(function() {
    $("label").removeClass("focus");
  });
}); // End Ready

var scrollHeaderController = function() {
  var linkHeader = $('body').find('.header-link-row'),
      width = $(window).width(),
      scroll;

  $('body').on('scroll', modifyHeader);

  function modifyHeader() {
    scroll = $('body').scrollTop();

    console.log(scroll);

    if ( scroll > 200 ) {
      $(linkHeader).addClass('hidden');
    }
    if ( scroll < 200 ) {
      $(linkHeader).removeClass('hidden');
    }
  }
}

function validateEmail(email) {
  var regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  return regex.test(email);
}

function validateInput(input) {
  var allowedChars = /^[\u00C0-\u1FFF\u2C00-\uD7FF\w&.,\- ]+$/;
  return allowedChars.test(input);
}

function validateNumber(input) {
  var isNumber = /^(?=.*[0-9])[+()0-9]+$/;
  return isNumber.test(input);
}

var reserveFormController = function() {
  var form = $('body').find('form.reserve'),
      emailInput = $(form).find('input[type=email]'),
      nameInput = $(form).find('input[type=text].name'),
      phoneInput = $(form).find('input[type=text].phone'),
      submitBtn = $(form).find('.submit-btn > a');

  function validateEmailOnBlur() {
    $(emailInput).on('blur', function() {
      var value = $(this).val();

      if ( value.length === 0 ) {
        if ( $(this).hasClass('error') ) {
          $(this).removeClass('error');
        }
        return;
      }

      if ( value.length !== 0 ) {
        var isEmail = validateEmail(value);

        if( !isEmail && !$(this).hasClass('error') ) {
          $(this).addClass('error');
        }

        if( isEmail && $(this).hasClass('error') ) {
          $(this).removeClass('error');
        }
      }
    });
  }

  function validateNameOnBlur() {
    $(nameInput).on('blur', function() {
      var value = $(this).val();

      if ( value.length === 0 ) {
        if ( $(this).hasClass('error') ) {
          $(this).removeClass('error');
        }
        return;
      }

      if ( value.length !== 0 ) {
        var isTrustedCharacters = validateInput(value);

        if( !isTrustedCharacters && !$(this).hasClass('error') ) {
          $(this).addClass('error');
        }

        if( isTrustedCharacters && $(this).hasClass('error') ) {
          $(this).removeClass('error');
        }
      }
    });
  }

  function validateNumberOnBlur() {
    $(phoneInput).on('blur', function() {
      var value = $(this).val();

      if ( value.length === 0 ) {
        if ( $(this).hasClass('error') ) {
          $(this).removeClass('error');
        }
        return;
      }

      if ( value.length !== 0 ) {
        var isNumber = validateNumber(value);

        if ( !isNumber && !$(this).hasClass('error') ) {
          $(this).addClass('error');
        }

        if ( isNumber && $(this).hasClass('error') ) {
          $(this).removeClass('error');
        }
      }
    });
  }

  function submitListener() {
    $(submitBtn).on('click', function(event) {
      event.preventDefault(),
      inputs = $(form).find('input'),
      validSuccess = $('body').find('.validation.success');
      dataObject = {},
      inputArray = [];

      $(inputs).each(function(i, e) {
        if ( $(e).hasClass('error') || $(e).val().length === 0 ) {
          return;
        } else {
          var object = {
            name: e.name,
            value: $(e).val()
          }
          inputArray.push(object);
        }
      });

      var data = packData();
      sendForm(data);
    });

    function packData() {
      dataObject.customer_html = '<h4>Navn:</h4><h2>' + inputArray[0].value + '</h2>';
      dataObject.customer_html += '<h4>TLF:</h4><h2>' + inputArray[1].value + '</h2>';
      dataObject.customer_html += '<h4>EMAIL:</h4><h2>' + inputArray[2].value + '</h2>';
      dataObject.customer_email = inputArray[2].value;

      return dataObject;
    }

    function sendForm(data) {
      var customerData = JSON.stringify(data);

        $.ajax({
          url: site.ajax_url + '?action=reserve',
          type: 'POST',
          data: customerData,
          success: function(response) {
            var stripResponse = $.trim(response);
            console.log(stripResponse);
            if ( stripResponse === 'Success' ) {
              animateSuccess();
            }
            if ( stripResponse === 'Error' ) {

            }
          },
          error: function(response) {
            console.log(response);

          }
        });
    }

    function animateSuccess() {
      $(form).velocity({
        'opacity': [0, 1]
      }, {duration: 300, delay: 0, easing: 'easeOutSine', display: 'none'});

      $(validSuccess).velocity({
        'opacity': [1, 0]
      }, {duration: 300, delay: 350, easing: 'easeOutSine', display: 'block'});

      setTimeout(function() {
        window.location.href = window.location.href;
      }, 1000);
    }
  }


  validateNumberOnBlur();
  validateEmailOnBlur();
  validateNameOnBlur();
  submitListener();
}


function shopMsg(title, msg) {
  var atcModal = $('body').find('.atc-modal');

  if ( !msg ) {
    var msg = '<span>- blev tilføjet til kurven.</span>';
  } else {
    var msg = msg;
  }

  var html = title + msg;

  $(atcModal).append(html);

  function animate() {
    $(atcModal).velocity({
      'opacity': [1, 0],
      'top': [100, 300],
      'z-index': [5000, 5000]
    }, {duration: 400, delay: 0, easing: 'easeInOutSine'});

    $(atcModal).velocity({
      'opacity': [0, 1],
      'top': [300, 100],
      'z-index': 5000
    }, {duration: 400, delay: 1400, easing: 'easeInOutSine'});
  }

  setTimeout(function() {
    animate();
  }, 100);

  setTimeout(function() {
    $(atcModal).html('');
    $(atcModal).css({
      'z-index': -1000
    });
    window.location.href = window.location.href;
  }, 2000);
}


var productTextController = function() {
  var textIcon = $('body').find('.text-icon'),
      productLeft = $('body').find('.product-left'),
      productRight = $('body').find('.product-right');

  $(textIcon).on('click', function() {
    toggleClass();
  });

  function toggleClass() {
    $(textIcon).toggleClass('off');
    $(productLeft).toggleClass('off');
    $(productRight).toggleClass('off');
  }

  setTimeout(toggleClass, 800);
}

var singleProductHeightController = function() {
  var mainImage = $('.main-image img');

  if ( mainImage && mainImage[0] ) {
    if (mainImage[0].complete) {
      handler();
    } else {
      mainImage.load(handler);
    }
  } else {
    return false;
  }

  function handler() {
    var contentHeight = $('.product-content').height(),
        imageHeight = $('.main-image img').height();

    if ( contentHeight && imageHeight < contentHeight ) {
      $('.main-image').css({
        'height': contentHeight + 'px'
      });
    } else {
      return;
    }
  }
}

var embedVidController = function() {
  var vidFrame = $('body').find('.youtube-frame');

  if ( vidFrame.length > 0 ) {
    initVideo();
  } else {
    return;
  }

  function initVideo() {
    var vidUrl = $(vidFrame).attr('data-href'),
        vidId = vidUrl.split('/');

    var width = $(window).width(),
        height = (width / 16) * 9;

    var constructedHtml = '<iframe width="' + width + '" height="' + height + '" src="https://www.youtube.com/embed/' + vidId[3] + '?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';

    $(vidFrame).html(constructedHtml);
  }
};


var gridCartController = function() {
  var addBtn = $('body').find('.add-button'),
      cart = $('body').find('.cart-contents');


  $(addBtn).each(function(i, e) {
    var id = $(this).attr('data-href'),
        prodTitle = $(this).attr('data-title');

    $(this).on('click', function(event) {
      event.preventDefault();
      var cartNumber = $('body').find('.cart-icon h5'),
          cartInt = parseInt($('body').find('.cart-icon h5').text()),
          url = site.ajax_url + '?action=sinus_add',
          dataObject = {
            'product_id': id
          }

      data = JSON.stringify(dataObject);

      $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'html',
        success: function(response) {
          var updatedNum = cartInt + 1;
          cartNumber.html(updatedNum);
          $(cart).html(response);
          shopMsg(prodTitle);
        },
        error: function(response) {
          console.log('error -', response);
        }
      });
    });
  });
};

var removeFromCartController = function() {
    var cart = $('body').find('.cart-contents'),
        remBtn = $(cart).find('.remove-icon');

  $(remBtn).each(function(i, e) {
    var id = $(this).attr('data-id'),
        qtyElem = $(this).siblings('.elem-qty-total'),
        qty = parseInt($(qtyElem).attr('data-qty'));


    $(this).on('click', function() {
      console.log(qty, id);
      var cartNumber = $('body').find('.cart-icon h5'),
          cartInt = parseInt($('body').find('.cart-icon h5').text()),
          url = site.ajax_url + '?action=sinus_remove',
          dataObject = {
            'product_id': id,
            'quantity': qty
          }

      data = JSON.stringify(dataObject);

      $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'html',
        success: function(response) {
          var updatedNum = cartInt - qty;
          cartNumber.html(updatedNum);
          $(cart).html(response);
          window.location.href = window.location.href;
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
      footerPosition = $(footer).position(),
      searchForm = $('body').find('.search-form'),
      cartIcon = $('body').find('.cart-icon'),
      cartContents = $('body').find('.cart-modal.cart-contents'),
      width = $(window).width();

      // set menu height, relative to content height
      $(mainMenu).css({
        'height': footerPosition.top + 150 + 'px'
      });

      $(menuBtn).on('click', animateMenu);

      function animateMenu() {
        if ( $(mainMenu).hasClass('hidden') ) {
          $(mainMenu).removeClass('hidden');
          $(this).addClass('open');
          updateHeaderOpen();
          addEventListener();
        } else {
          $(mainMenu).addClass('hidden');
          $(this).removeClass('open');
          updateHeaderClose();
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
            }, {duration: 400, delay: 100, easing: 'easeOutSine'});

            $(searchForm).velocity({
              'right': searchRight + 230 + 'px'
            }, {duration: 400, delay: 0, easing: 'easeOutSine'});

            $(cartContents).velocity({
              'right': cartContRight + 230 + 'px'
            }, {duration: 400, delay: 150, easing: 'easeOutSine'});
      }

      function updateHeaderClose() {
            $(cartIcon).velocity({
              'right': 90
            }, {duration: 300, delay: 200, easing: 'easeOutSine'});

            $(searchForm).velocity({
              'right': 165
            }, {duration: 300, delay: 300, easing: 'easeOutSine'});

            $(cartContents).velocity({
              'right': 80
            }, {duration: 300, delay: 250, easing: 'easeOutSine'});
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


var CartController = function() {
  var cartIcon = $('body').find('.cart-icon'),
      cartContents = $('body').find('.cart-modal.cart-contents');

  $(cartIcon).on('click', function(e) {
    $(cartContents).toggleClass('hidden');
  });
}

// var SineAnimation = function() {
//   var container = $('body').find('.sine-animation'),
//       imgContainer = $(container).find('.img-container');

//       var options = {
//         'duration': 5000,
//         'delay': 8000,
//         'easing': 'easeInOutSine',
//         'loop': true
//       }

//       $(imgContainer).velocity({
//         'left': [-310, 0]
//       }, options);
// };
