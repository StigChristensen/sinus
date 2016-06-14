import velocity from 'velocity-animate';
const $ = jQuery;

module.exports = {
  sortStockController: ()=> {
    var productsInStock = $('.product-list-grid.front').find('.stock-true'),
        productsOutOfStock = $('.product-list-grid.front').find('.stock-false'),
        inStockBtn = $('body').find('input[type=checkbox].instock'),
        outOfStockBtn = $('body').find('input[type=checkbox].outofstock');

    $(inStockBtn).on('change', function() {
      if ( this.checked === false ) {
        $(productsInStock).each(function(i,e) {
          var del = 50 * i;
          $(e).velocity({
            'opacity': [0,1]
          }, {duration: 300, delay: del, display: 'none', easing: [.24,.63,.5,.99]});
        });
      }

      if ( this.checked === true ) {
        $(productsInStock).each(function(i,e) {
          var del = 50 * i;
          $(e).velocity({
            'opacity': [1,0]
          }, {duration: 300, delay: del, display: 'block', easing: [.24,.63,.5,.99]});
        });
      }
    });

    $(outOfStockBtn).on('change', function() {
      if ( this.checked === false ) {
        $(productsOutOfStock).each(function(i,e) {
          var del = 50 * i;
          $(e).velocity({
            'opacity': 0
          }, {duration: 300, delay: del, display: 'none', easing: [.24,.63,.5,.99]});
        });
      }

      if ( this.checked === true ) {
        $(productsOutOfStock).each(function(i,e) {
          var del = 50 * i;
          $(e).velocity({
            'opacity': 1
          }, {duration: 300, delay: del, display: 'block', easing: [.24,.63,.5,.99]});
        });
      }
    });
  },

  sortPriceController: ()=> {
    function setDirection(dir) {
      direction = dir;
    }

    function getDirection() {
      return direction;
    }

    var priceSorter = $('.menu-left').find('.sort-links > .price-sorter');

    if ( !priceSorter ) {
      return;
    }

    $(priceSorter).on('click', function() {
      if ( initDirection ) {
        currentDir = initDirection;
        setDirection(initDirection);
      } else {
        var currentDir = 'asc';
      }

      if ( currentDir === 'asc' ) {
        changeDirection('desc');
        var price = 'price_asc';
        sortUrl(price);
      }

      if ( currentDir === 'desc' ) {
        changeDirection('asc');
        var price = 'price_desc';
        sortUrl(price);
      }

      function changeDirection(newDir) {
        setTimeout(function () {
          setDirection(newDir);
        }, 1500);
      }
    });
  }
}
