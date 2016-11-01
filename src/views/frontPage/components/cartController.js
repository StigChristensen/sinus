import velocity from 'velocity-animate';
const $ = jQuery;

module.exports = {
  toggleCart: function() {
    $('body').on('click', '.cart-icon', function(e) {
      let scrollAmount = window.pageYOffset || document.documentElement.scrollTop;
      let cartModal = $('body').find('.cart-modal.cart-contents'),
          siteContent = $('body').find('.site-content'),
          subMenu = $('body').find('.header-link-row');

      if ( scrollAmount > 600 ) {
        $(cartModal).toggleClass('fixed-open');
        $(cartModal).toggleClass('hidden');
      } else {
        $(subMenu).toggleClass('hidden');
        $(cartModal).toggleClass('hidden');
        $(siteContent).toggleClass('modal-open');
      }
    });
  },

  addToCartController: function() {
    let self = this;

    $('body').on('click', function(event) {
      let addBtn = $(event.target).closest('.add-button');

      if ( $(addBtn).length === 1 ) {
        let id = $(addBtn).attr('data-href'),
            title = $(addBtn).attr('data-title');

        updateCart(id, title);
      } else {
        return;
      }

    });

    function updateCart(id, title) {
      let cart = $('body').find('.cart-contents'),
          cartNumber = $('body').find('.cart-icon h5'),
          cartInt = parseInt($('body').find('.cart-icon h5').text()),
          url = site.ajax_url + '?action=sinus_add',
          dataObject = {
              'product_id': id
            }

      let data = JSON.stringify(dataObject);

      $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'html',
        success: function(response) {
          var updatedNum = cartInt + 1;
          cartNumber.html(updatedNum);
          $(cart).html(response);
          self.shopMsg(title);
        },
        error: function(response) {
          console.log('error -', response);
        }
      });
    }
  },

  removeFromCartController: ()=> {
      var cart = $('body').find('.cart-contents'),
          remBtn = $(cart).find('.remove-icon');

    $(remBtn).each(function(i, e) {
      var id = $(this).attr('data-id'),
          qtyElem = $(this).siblings('.elem-qty-total'),
          qty = parseInt($(qtyElem).attr('data-qty'));


      $(this).on('click', function() {
        var cartNumber = $('body').find('.cart-icon h5'),
            cartInt = parseInt($('body').find('.cart-icon h5').text()),
            url = site.ajax_url + '?action=sinus_remove',
            dataObject = {
              'product_id': id,
              'quantity': qty
            }

        let data = JSON.stringify(dataObject);

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
  },

  shopMsg: function(title, msg) {
    var atcModal = $('body').find('.atc-modal');

    if ( !msg ) {
      var msg = '<span>- blev tilføjet til kurven.</span>';
    } else {
      var msg = msg;
    }

    var html = '<h3>' + title + '</h3>' + msg;

    $(atcModal).append(html);

    function animate() {
      $(atcModal).velocity({
        'opacity': [1, 0],
        'top': [150, 300],
        'z-index': [999999999998, 999999999998]
      }, {duration: 400, delay: 0, easing: 'easeInOutSine'});

      $(atcModal).velocity({
        'opacity': [0, 1],
        'top': [300, 150],
        'z-index': [999999999998, 99999999998]
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
    }, 2500);
  }
}
