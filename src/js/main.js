// Test if ie10 - adds class "ie10" to HTML tag, if true. - Excludes IE11
if (/*@cc_on!@*/false && document.documentMode === 10) {
    document.documentElement.className+=' ie10';
}

jQuery(document).on('ready', function() {
  $ = jQuery;

  new CartController();
  new MenuController();
  new removeFromCartController();
  new reserveFormController();
  new scrollHeaderController();
  new embedVidController();
  new fpVideoController();
  new fpBackgroundController();
  urlListener();
  searchFormController();

  // labels for input fields
  $("form :input").focus(function() {
    $("label[for='" + this.id + "']").addClass("focus");
  }).blur(function() {
    $("label").removeClass("focus");
  });
}); // End Ready

var documentHeight;

function scrollTo(value) {
  $('html, body').animate({
    scrollTop: value
  }, 700);
}

function show404(type) {
  var container = $('body').find('.product-list-grid'),
      spinner = $('body').find('.spinner');
      html404;

  if ( type === 'search' ) {
    var message = 'Der er desværre ingen resultater, der matcher det du søger efter.';
    var html404 = '<div class="contained-404 hidden"><h3>' + message + '</h3></div>';
    $(container).html(html404);

    $(container).css({
        'background-color': '#000000',
        'margin-bottom': 0
      });

    setTimeout(function() {
      var mess = $(container).find('.contained-404');
      animateIn(mess);
    }, 200);
  }

  if ( type === 'remove' ) {
    var mess = $(container).find('.contained-404');
    if ( mess && !$(mess).hasClass('hidden') ) {
      $(container).css({
          'background-color': '#FDFDFD',
          'margin-bottom': 100
        });

      setTimeout(function() {

        animateOut(mess);
      }, 200);
    }
  }

  function animateIn(elem) {
    if ( !$(spinner).hasClass('hidden') ) {
      $(spinner).addClass('hidden');
    }
    $(elem).removeClass('hidden');
  }

  function animateOut(elem) {
    // $(spinner).reClass('hidden');
    $(elem).addClass('hidden');
  }
}

var modalController = function() {
  var prods = $('body').find('li.product'),
      modal = $('body').find('.product-modal'),
      content = $(modal).find('.modal-content');
      modalOverlay = $('body').find('.product-modal-overlay'),
      modalClose = $(modal).find('.modal-close-btn');

  $(prods).each(function(i,e) {

    $(e).on('click', function(event) {
      var prod_id = $(e).data('singleid');
      event.preventDefault();

      var getData = get_content(prod_id);

      getData.done(function(data) {
        modalRender(data, modal);
      })
      .fail(function() {
        return;
      });
    });
  });

  function modalRender(data) {
    $(content).html(data);

    setTimeout(function() {
      new embedVidController();
      new CartController();
      addEventListeners();
      animateIn();
    }, 200);
  }

  function addEventListeners() {
    $(modalOverlay).on('click', function() {
      animateOut();
    });

    $(modalClose).on('click', function() {
      animateOut();
    });
  }

  function get_content(id) {
    var contentDef = $.Deferred(),
        id = id;
        url = site.ajax_url + '?action=sinus_getsinglehtml',
        dataObject = {
          id: id
        }

    var data = JSON.stringify(dataObject);

    $.ajax({
      url: url,
      type: "POST",
      data: data,
      success: function(response) {
        contentDef.resolve(response);
      },
      error: function(response) {
        contentDef.reject(response);
      }
    });
    return contentDef;
  }

  function animateIn() {
    $(modal).removeClass('hidden');
    $(modalOverlay).removeClass('hidden');
  }

  function animateOut() {
    $(modal).addClass('hidden');
    $(modalOverlay).addClass('hidden');
  }

}

function productsController() {
  var promise = productsSupplyer();
  promise.then(function(products) {
    render(products);
  });
  sortPriceController('asc');
}

function urlListener() {
  var href = window.location.href,
      hash = window.location.hash,
      type = href.indexOf('/type/'),
      brands = href.indexOf('/brands/'),
      search = href.indexOf('#s='),
      initParams,
      base_url;

  if ( type === -1 && brands === -1 && search === -1 ) {
    return;
  } else {
    if ( !hash ) {
        productsController();
    } else {
      if ( search !== -1 ) {
        getSearchParams(hash);
      } else {
        console.log(search);
        sortHash(hash);
      }
    }
  }

  window.onhashchange = function(event) {
    hash = window.location.hash;
    search = hash.indexOf('#s=');

    if ( search !== -1 ) {
      getSearchParams(hash);
    } else {
      sortHash(hash);
    }
  }

  function getSearchParams(hash) {
    var parts = hash.split('#s=');

    var getParams = parts[1].split('&');
    var searchParams = getParams[0].split('+');
    searchController(searchParams);
  }
}

function searchFormController() {
  var form = $('body').find('form.sinus-search'),
      input = $(form).find('input[type=text]');

  $(form).on('submit', function(event) {
    event.preventDefault();
    var val = $(input).val();

    if ( val.length < 1 ) {
      $(input).attr('placeholder', 'Mindst 3 tegn...');
      return;
    }

    if ( val.length > 1 ) {
      if ( val.indexOf(' ') !== -1 ) {
        val.replace(' ', '+');
      }

      var encoded = encodeURI(val);
      var hash = '#s=' + encoded;

      setUrl(hash);
    }
  });
}

function searchController(searchParams) {
  if ( searchParams ) {
    var decodedParams = [];
    $(searchParams).each(function(i,e) {
      var p = decodeURIComponent(e);

        if ( p.indexOf(' ') !== -1 ) {
          var split = p.split(' ');
          $(split).each(function(i, par) {
            decodedParams.push(par);
          });
        } else {
          decodedParams.push(p);
        }
    });

    var getSearchProducts = returnSortedSearch(decodedParams);

    getSearchProducts.then(function(products) {
      render(products);
    });

  } else {
    return;
  }
}

function returnSortedSearch(params, products) {
  var sorted = [],
      defer = $.Deferred();

  if ( !products ) {
    var newProductsPromise = productsSupplyer();
    newProductsPromise.then(function(newProducts) {
      var results = sort(newProducts);
    });
  } else {
    sort(products);
  }

  function sort(products) {
    $(products).each(function(i,e) {
      var cats = e.categories,
          tags = e.tags,
          title = e.title,
          desc = e.description,
          stripped = desc.replace(/<(?:.|\n)*?>/gm, '').toLowerCase(),
          lowerCats = [],
          lowerTags = [];

      var lowerTitle = title.toLowerCase();
      var lowerDesc = desc.toLowerCase();

      $(cats).each(function(i, a) {
        var b = a.toLowerCase();
        lowerCats.push(b);
      });

      $(tags).each(function(i, a) {
        var b = a.toLowerCase();
        lowerTags.push(b);
      });


      for (var i = 0; i < params.length; i++) {
        par = params[i].toLowerCase();

        if ( lowerCats.indexOf(par) !== -1 ) {
          sorted.push(e);
        }

        if ( lowerTags.indexOf(par) !== -1 ) {
          sorted.push(e);
        }

        if ( title.indexOf(par) !== -1 ) {
          sorted.push(e);
        }

        if ( stripped.indexOf(par) !== -1 ) {
          sorted.push(e);
        }
      }

    });

    function sortByFrequency(array) {
      var frequency = {};

      array.forEach(function(value) { frequency[value] = 0; });

      var uniques = array.filter(function(value) {
          return ++frequency[value] == 1;
      });

      return uniques.sort(function(a, b) {
          return frequency[b] - frequency[a];
      });
    }

    var getTopHits = sorted.sort(sortByFrequency(sorted));

    var uniq = _.uniq(getTopHits, true);

    defer.resolve(uniq);
  }

  return defer;
}

function sortHash(hash) {
  var price, param, paramtype, splitHash, splitParams, newDirection;

  if ( hash.indexOf('#s=') !== -1 ) {
    return;
  }

  if ( hash.indexOf('price_asc') !== -1 ) {
    price = 'price_asc';
    newDirection = 'price_desc';
    sortPriceController(newDirection);
  }

  if ( hash.indexOf('price_desc') !== -1 ) {
    price = 'price_desc';
    newDirection = 'price_asc';
    sortPriceController(newDirection);
  }

  if ( hash.indexOf('category') !== -1 ) {
    paramtype = 'category';
  }

  if ( hash.indexOf('brand') !== -1 ) {
    paramtype = 'brand';
  }

  if ( paramtype ) {
    splitHash = hash.split('=');
    splitParams = splitHash[1].split('+');
    var pAsc = splitParams.indexOf('price_asc');
    var pDesc = splitParams.indexOf('price_desc');

    if ( pAsc === 0 || pDesc === 0 ) {
      param = splitParams[2];
    } else {
      param = splitParams[1];
    }
  }

  console.log(price, paramtype, param);

  sortUrl(price, param, paramtype);
}

function sortUrl(price, param, paramtype) {
  var h = window.location.hash,
      href = window.location.href,
      pri, par, pt,
      hashBase = '#sort=',
      paramArray = [],
      base_url;

  if ( h ) {
    var base = href.split('#');
    base_url = base[0];

    if ( price ) {
      pri = price;
      paramArray.push(pri);
    } else {
      if ( h.indexOf('price_asc') !== -1 ) {
        pri = 'price_asc';
        paramArray.push(pri);
      }
      if ( h.indexOf('price_desc') !== -1 ) {
        pri = 'price_desc';
        paramArray.push(pri);
      }
    }

    if ( param ) {
      par = param;
      pt = paramtype;
      paramArray.push(pt);
      paramArray.push(par);
    } else {
      if ( h.indexOf('category') !== -1 ) {
        paramtype = 'category';
        var getParam = h.split('category');
        var cat = getParam[1].replace('+', '');
        par = cat;
        paramArray.push(paramtype);
        paramArray.push(par);
      }

      if ( h.indexOf('brand') !== -1 ) {
        paramtype = 'brand';
        var getParam = h.split('brand');
        var cat = getParam[1].replace('+', '');
        par = cat;
        paramArray.push(paramtype);
        paramArray.push(par);
      }
    }

  } else {
    base_url = href;

    if ( price ) {
      pri = price;
      paramArray.push(pri);
    }

    if ( param ) {
      par = param;
      pt = paramtype;
      paramArray.push(pt);
      paramArray.push(par);
    }
  }

  var string = '';
      string = hashBase;

  var paramsLength = paramArray.length;
  $(paramArray).each(function(i, e) {
    if ( i < (paramsLength-1) ) {
      string += e + '+';
    }
    if ( i === (paramsLength-1) ) {
      string += e;
    }
  });

  setUrl(string, base_url);
  urlDataController(pri, par, pt);
}

function setUrl(hash, href) {
  if ( !href ) {
    window.location.hash = hash;
  } else {
    window.location.href = href + hash;
  }
}

function urlDataController(price, param, paramtype) {
  if ( price && param === undefined && param === undefined ) {

    if ( price === 'price_asc' ) {
      var dataPromise = returnSortedPriceLow();

      dataPromise.done(function(products) {
        render(products);
      })
      .fail(function() {
          console.log('failed!');
      });
    }

    if ( price === 'price_desc' ) {
      var dataPromise = returnSortedPriceHigh();

      dataPromise.done(function(products) {
        render(products);
      })
      .fail(function() {
          console.log('failed!');
      });
    }
  }

  if ( price === undefined && param && paramtype ) {
    if ( paramtype === 'category' ) {
      var dataPromise = returnSortedCat(param);

      dataPromise.done(function(products) {
        render(products);
      })
      .fail(function() {
          console.log('failed!');
      });
    }

    if ( paramtype === 'brand' ) {
      var dataPromise = returnSortedBrand(param);

      dataPromise.done(function(products) {
        render(products);
      })
      .fail(function() {
          console.log('failed!');
      });
    }
  }

  if ( price && param && paramtype) {
    var dataPromise = returnSortedMultiple(price, param, paramtype);

    dataPromise.done(function(products) {
      render(products);
    })
    .fail(function() {
        console.log('failed!');
    });
  }

  sortPriceController();
}

function returnSortedMultiple(price, param, paramtype) {
  var sortdef = $.Deferred();

  function getFirstList() {
    var getFirst = $.Deferred();

    if ( price ) {
      if ( price === 'price_asc' ) {
        var init = returnSortedPriceLow();

        init.then(function(sortedPrice) {
          getFirst.resolve(sortedPrice);
        });
      }

      if ( price === 'price_desc' ) {
        var init = returnSortedPriceHigh();

        init.then(function(sortedPrice) {
          getFirst.resolve(sortedPrice);
        });
      }

    } else {
      getFirst.reject('first rejected');
    }
    return getFirst;
  }

  function getSecondList() {
    var getSecond = $.Deferred();
    var firstPromise = getFirstList();

    firstPromise.then(function(sortedPrice) {
      if ( sortedPrice ) {

        if ( param ) {
          if ( paramtype === 'brand' ) {
            var finalSort = returnSortedBrand(param, sortedPrice);
            finalSort.then(function(brandSorted) {
              getSecond.resolve(brandSorted);
            });
          }

          if ( paramtype === 'category' ) {
            var finalSort = returnSortedCat(param, sortedPrice);
            finalSort.then(function(catSorted) {
              getSecond.resolve(catSorted);
            });
          }
        } else {
          getSecond.reject('rejected - no param', sortedPrice);
        }
      }

      if ( !sortedPrice && param ) {
        if ( paramtype === 'brand' ) {
            var finalSort = returnSortedBrand(param);
            finalSort.then(function(brandSorted) {
              getSecond.resolve(brandSorted);
            });
          }

          if ( paramtype === 'category' ) {
            var finalSort = returnSortedCat(param);
            finalSort.then(function(catSorted) {
              getSecond.resolve(catSorted);
            });
          }
      } else {
        getSecond.reject('rejected !products && param');
      }
    });

    return getSecond;
  }

  $.when( getSecondList() ).then(function(data) {
    sortdef.resolve(data);
  });

  return sortdef;
}



function returnSortedCat(param, products) {
  var sorted = [],
      defer = $.Deferred();

  if ( !products ) {
    var newProductsPromise = productsSupplyer();

    newProductsPromise.then(function(newProducts) {
      $(newProducts).each(function(i,e) {
        var cats = e.categories;
        if ( cats.indexOf(param) !== -1 ) {
          sorted.push(e);
        }
      });

      defer.resolve(sorted);
    });
  } else {
    function sort() {
      $(products).each(function(i,e) {
        var categories = e.categories;
        if ( categories.indexOf(param) !== -1 ) {
          sorted.push(e);
        }
      });

      defer.resolve(sorted);
    }

    sort();
  }

  return defer;
}

function returnSortedBrand(param, products) {
  var sorted = [];
  var defer = $.Deferred();

  if ( !products ) {
    var newProductsPromise = productsSupplyer();

    newProductsPromise.then(function(newProducts) {
      $(newProducts).each(function(i,e) {
        var brands = e.tags;
        if ( brands.indexOf(param) !== -1 ) {
          sorted.push(e);
        }
      });

      defer.resolve(sorted);
    });
  } else {
    function sort() {
      $(products).each(function(i,e) {
        var brands = e.tags;
        if ( brands.indexOf(param) !== -1 ) {
          sorted.push(e);
        }
      });

      defer.resolve(sorted);
    }

    sort();
  }

  return defer;
}

function returnSortedPriceLow() {
  var newProductsPromise = productsSupplyer(),
      defer = $.Deferred();

  newProductsPromise.then(function(newProducts) {
    var initArray = [],
        sorted = [];

    $(newProducts).each(function(i,e) {
      var object = {
        price: parseInt(e['regular_price']),
        element: e
      }
      initArray.push(object);
    });

    function sortPrice(a,b) {
      return a.price - b.price;
    }

    var initialSort = initArray.sort(sortPrice);

    $(initialSort).each(function(j,f) {
      sorted.push(f.element);
    });

    defer.resolve(sorted);
  });

  return defer;
}

function returnSortedPriceHigh() {
  var newProductsPromise = productsSupplyer(),
      defer = $.Deferred();

  newProductsPromise.then(function(newProducts) {
    var initArray = [],
        sorted = [];

    $(newProducts).each(function(i,e) {
      var object = {
        price: parseInt(e['regular_price']),
        element: e
      }
      initArray.push(object);
    });

    function sortPrice(a,b) {
      return a.price - b.price;
    }

    var initialSort = initArray.sort(sortPrice).reverse();

    $(initialSort).each(function(j,f) {
      sorted.push(f.element);
    });

    defer.resolve(sorted);
  });

  return defer;
}


function productsSupplyer() {
  var url = window.location.href;
  var def = $.Deferred();
  var urlType = url.indexOf('/type/'),
      urlBrands = url.indexOf('/brands/'),
      urlSearch = url.indexOf('#s='),
      urlProducts = url.indexOf('/products/');

  if ( urlType === -1 && urlBrands === -1 && urlSearch === -1 && urlProducts === -1 ) {
    console.log('Exited from productsModel');
    return;
  }

  var productsCache,
      products,
      storage = storageAvailable('localStorage'),
      target = $('body').find('.product-list-grid'),
      pageIndex,
      maxPages,
      type,
      brand,
      key,
      query = {};
      tags = {
        brands: [],
        categories: []
      };
      initialize();

  function storageAvailable(type) {
    try {
      var storage = window[type],
        x = '__storage_test__';
      storage.setItem(x, x);
      storage.removeItem(x);
      return true;
    }
    catch(e) {
      return false;
    }
  }

  function setPageIndex(index) {
    pageIndex = index;
  }

  function getPageIndex() {
    var p = pageIndex;
    return p;
  }

  function setMaxPages(max) {
    maxPages = max;
  }

  function getMaxPages() {
    var p = maxPages;
    return p;
  }

  function setQueryType() {
    var parts;
    if ( urlType !== -1 ) {
      parts = url.split('/');

      query = {
        type: 'type',
        param: parts[4]
      }
    }

    if ( urlBrands !== -1 ) {
      parts = url.split('/');

      query = {
        type: 'brand',
        param: parts[4]
      }
    }

    if ( urlSearch !== -1 || urlProducts !== 1 ) {
      parts = [];

      query = {
        type: 'all',
        param: 'null'
      }
    }
  }

  function getQueryType() {
    return query;
  }

  function initialize() {
    var container = $('body').find('.products-container'),
        pageIndex = $(container).data('page'),
        maxPages = $(container).data('maxpages'),
        type = $(container).data('cat'),
        brand = $(container).data('tag');
        setQueryType();
        setMaxPages(maxPages);

    if ( !pageIndex || pageIndex > maxPages ) {
      setPageIndex(1);
    } else {
      setPageIndex(pageIndex);
    }

    var int = getPageIndex();
    var queryParams = getQueryType();
    key = queryParams.type + '_' + queryParams.param;

    if ( storage ) {
      productsCache = localStorage,
      products = JSON.parse(productsCache.getItem(key));
      if (products) {
        def.resolve(products);
      } else {
        getPosts();
      }
    } else {
      // load something else, maybe
      console.log('no localStorage for us');
    }
  }

  function getPosts() {
    var queryType = getQueryType(),
        action,
        type = queryType.type;

    if ( type === 'type' ) {
      action = '?action=sinus_type';
    }
    if ( type === 'brand' ) {
      action = '?action=sinus_brand';
    }

    if ( type === 'all' ) {
      action = '?action=sinus_products';
    }

    console.log(type, queryType.param);
    var queryParams = {
        offset: 0,
        limit: -1,
        param: queryType.param
    },
    dataObj = JSON.stringify(queryParams);

    $.ajax({
      url: site.ajax_url + action,
      type: "POST",
      data: dataObj,
      dataType: 'json',
      success: function(response) {
        products = response.products;
        productsCache.setItem(key, JSON.stringify(products));
        def.resolve(products);
      },
      error: function(response) {
        console.log(response);
      }
    });
  }

  return def;
}

function render(products) {
  if ( products.length > 0 ) {
    show404('remove');
  } else {
    show404('search');
    return;
  }

  var grid = $('body').find('.product-list-grid'),
      spinner = $('body').find('.spinner'),
      pages = $('body').find('.page.products'),
      length = products.length;

  if ( !$(spinner).hasClass('hidden') ) {
    $(spinner).addClass('hidden');
  }

  if ( pages ) {
    $(pages).each(function(pi,pe) {
      $(pe).remove();
    });
  }

  function loop() {
    loopDef = $.Deferred();

    var pageIndex = 1;
    var html = '<div class="page products page-1 hidden">';
        html += '<ul class="products">';

    $(products).each(function(i, e) {
      var k = i + 1;

      var getTemplate = setTemplate(e);

      getTemplate.then(function(template) {
        html += template;
      });

      $(e.tags).each(function(ti, te) {
        tags.brands.push(te);
      });

      $(e.categories).each(function(ci, ce) {
        tags.categories.push(ce);
      });

      if ( k % 24 === 0 && i < length ) {
        pageIndex++;
        html += '</ul>';
        html += '</div>';
        html += '<div class="page products page-' + pageIndex + ' hidden">';
        html += '<ul class="products">';
      }
    });

    html += '</ul>';
    html += '</div>';

    loopDef.resolve(html);
    return loopDef;
  }

  var loopPromise = loop();

  loopPromise.then(function(html) {
    $(grid).append(html);
    sortTags(tags);
    scrollController();
    setMenuHeight();
    var page = $('body').find('.page.page-1');
    $(page).removeClass('hidden');
    setTimeout(function() {
      new gridCartController();
      new modalController();
    }, 1500);
  });

}


function setTemplate(e) {
  var stockIcon, template;
      tempDefer = $.Deferred();

  function prepare() {
    if ( e.stock_quantity === 0 ) {
      stockIcon = '<div class="in-stock-icon"><span>PÅ LAGER: <i class="fa fa-minus-square"></i></span></div>';
    }

    if ( e.stock_quantity > 0 ) {
      stockIcon = '<div class="in-stock-icon"><span>PÅ LAGER: <i class="fa fa-check-square"></i></span></div>';
    }

    var desc = e.description;
    var stripped = desc.replace(/<(?:.|\n)*?>/gm, '');

    var template = '<li class="product" itemscope itemtype="http://schema.org/Product" data-singleid="' + e.id + '">';
        template += stockIcon;
        template += '<img src="' + e.featured_src + '" alt="' + e.title + ' product image produkt billede Sinus-store Copenhagen København Denmark" />';
        template += '<div class="product-title" itemprop="name"><h3>' + e.title + '</h3></div>';
        template += '<div class="product-price">' + e.price_html + '<div class="add-button" data-href="' + e.id + '" data-title="' + e.title + '"><svg version="1.1" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"x="0px" y="0px" viewBox="0 0 60 60" xml:space="preserve"><line class="svg-line" fill="none" stroke="#007c96" stroke-width="10" stroke-miterlimit="10" x1="30" y1="6" x2="30" y2="54"/><line class="svg-line" fill="none" stroke="#007c96" stroke-width="10" stroke-miterlimit="10" x1="6" y1="30" x2="54" y2="30"/></svg><span class="add-info">Tilføj til kurv</span></div></div>';
        template += '<div class="sinus-product-info"><div class="short-desc" itemprop="description"><p>' + desc.split(" ").splice(0, 40).join(" ") + '... </p></div></div>';
        template += '</li>';

    tempDefer.resolve(template);
  }

  prepare();
  return tempDefer;
}


function sortTags(tags) {
  var menuLeft = $('body').find('.menu-left'),
      categoryContainer = $(menuLeft).find('.categories'),
      brandContainer = $(menuLeft).find('.brands'),
      categories = _.uniq(tags.categories),
      brands = _.uniq(tags.brands),
      pCat = $(categoryContainer).find('p'),
      pBrand = $(brandContainer).find('p'),
      catHtml,
      brandHtml;

  if ( pCat.length !== 0 || pBrand.length !== 0 ) {
    return
  } else {
    $(categories).each(function(i, cat) {
      catHtml = '<p data-cat="' + cat + '"><i class="fa fa-search-plus"></i>' + cat + '</p>';
      $(categoryContainer).append(catHtml);
    });

    $(brands).each(function(i, brand) {
      brandHtml = '<p data-brand="' + brand + '"><i class="fa fa-search-plus"></i>' + brand + '</p>';
      $(brandContainer).append(brandHtml);
    });

    setTimeout(function() {
      sortController();
    }, 1500);
  }
}

function sortController() {
  var menuLeft = $('body').find('.menu-left'),
      categoryContainer = $(menuLeft).find('.categories'),
      brandContainer = $(menuLeft).find('.brands'),
      pCat = $(categoryContainer).find('p'),
      pBrand = $(brandContainer).find('p'),
      products = $('body').find('li.product'),
      pages = $('body').find('.page.products'),
      href = window.location.href;

  $(pCat).each(function(i,e) {
    var param = $(e).data('cat');

    $(e).on('click', function() {
      $(pages).each(function(i,e) {
        var delay = 50 * i;
        $(e).velocity({'opacity': 0}, {duration: 500, delay: delay, display: 'none', easing: [.24,.63,.5,.99]});
        setTimeout(function() {
          $(e).detach();
        }, 600+delay);
      });
      var paramtype = 'category';
      var price = null;
      sortUrl(price, param, paramtype);

    });
  });

  $(pBrand).each(function(i,e) {
    var param = $(e).data('brand');

    $(e).on('click', function() {
      $(pages).each(function(i,e) {
        var delay = 50 * i;
        $(e).velocity({'opacity': 0}, {duration: 500, delay: delay, display: 'none', easing: [.24,.63,.5,.99]});
        setTimeout(function() {
          $(e).detach();
        }, 600+delay);
      });
      var paramtype = 'brand';
      var price = null;
      sortUrl(price, param, paramtype);
    });
  });
}

function sortPriceController(initDirection) {
  var direction = initDirection;

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
    var currentDir = getDirection();

    console.log(currentDir);

    if ( currentDir === 'asc' ) {
      setDirection('desc');
      var price = 'price_asc';
      sortUrl(price);

    }

    if ( currentDir === 'desc' ) {
      setDirection('asc');
      var price = 'price_desc';
      sortUrl(price);
    }
  });
}

function scrollController() {
  var pages = $('body').find('.page.products.hidden'),
      content = $('body').find('.site-content'),
      height = $(content).height(),
      windowHeight = $(window).height();

  if ( !pages ) {
    return;
  }

  $(window).on('scroll', function() {
    var scroll = $(document).scrollTop(),
        height = $(content).height();

    if ( scroll >= ((height - windowHeight) - 700) ) {
      window.requestAnimationFrame(function() {
        updateView();
      });
    }
  });

  function updateView() {
    var trig = 0;
    if (!pages[0] || trig > 0 ) {
      return;
    } else {
      $(pages[0]).removeClass('hidden');
      trig++;
      setTimeout(function() {
        scrollController();
      }, 1000);
    }
  }
}

var fpBackgroundController = function() {
  var bgContainer = $('body').find('.bg-container'),
      firstImg = $(bgContainer).find('img'),
      index;

  if ( !bgContainer ) {
    return;
  }

  if ( firstImg && firstImg[0] ) {
    if (firstImg[0].complete) {
      imagesHandler();
    } else {
      firstImg.load(imagesHandler);
    }
  }

  function imagesHandler() {
    setIndex(1);
    $(firstImg).velocity({
      'opacity': 1
    }, {duration: 500, delay: 0, display: 'block', easing: [.24,.63,.5,.99]});

    for( var i = 2; i < 7; i++ ) {
      var img = $('<img />').attr('src', site.theme_path + '/img/bg/bg' + i + '.png').attr('class', 'bg-' + i);
      $(bgContainer).append(img);
    }

    setTimeout(controller, 8000);
  }

  function controller() {
    var j = getIndex(),
        k = j+1;

    if ( k > 6 ) {
      k = 1;
    }

    var curImg = $(bgContainer).find('img.bg-' + j),
        newImg = $(bgContainer).find('img.bg-' + k);

    window.requestAnimationFrame(animateIn(newImg));
    window.requestAnimationFrame(animateOut(curImg));

    setIndex(k);

    setTimeout(controller, 4000);
  }

  function animateIn(image) {
    $(image).velocity({
      'opacity': 1
    }, {duration: 1000, delay: 0, display: 'block', easing: [.24,.63,.5,.99]});
  }

  function animateOut(image) {
    $(image).velocity({
      'opacity': 0
    }, {duration: 1000, delay: 0, display: 'block', easing: [.24,.63,.5,.99]});
  }

  function getIndex() {
    n = index;
    return n;
  }

  function setIndex(newIndex) {
    index = newIndex;
  }
}

var fpVideoController = function() {
  var vid = document.getElementById('frontpage-video');

  if (!vid) {
    return;
  } else {
    var spinner = $('body').find('.spinner'),
        container = $('body').find('.front-video-container'),
        vidElement = $(container).find('#frontpage-video'),
        movingContent = $('body').find('.moving-content'),
        width = $(window).width(),
        vidHeight = ((width/100*80)/16)*9;

    addEventListeners();
  }

  function addEventListeners() {
    vid.addEventListener('canplaythrough', animShowVideo);
    vid.addEventListener('ended', animOutVideo);
  }

  function animShowVideo() {
    $(spinner).addClass('hidden');

    $(container).velocity({
      'height': vidHeight
    }, {duration: 700, delay: 0, easing: [.24,.63,.5,.99]});

    $(vidElement).velocity({
      'opacity': 1
    }, {duration: 700, delay: 0, display: 'block', easing: [.24,.63,.5,.99]});

    $(movingContent).velocity({
      'top': vidHeight + 30
    }, {duration: 700, delay: 0, display: 'block', easing: [.24,.63,.5,.99]});

    setTimeout(function() {
      if ( vid.paused ) {
        vid.play();
      }
    }, 700);
  }

  function animOutVideo() {
    $(vidElement).velocity({
      'opacity': 0
    }, {duration: 300, delay: 0, display: 'block', easing: [.24,.63,.5,.99]});

    $(container).velocity({
      'height': 60
    }, {duration: 1000, delay: 400, easing: [.24,.63,.5,.99]});

    $(movingContent).velocity({
      'top': 90
    }, {duration: 1000, delay: 400, display: 'block', easing: [.24,.63,.5,.99]});

    scrollTo(0);
  }
}


var scrollHeaderController = function() {
  var linkHeader = $('body').find('.header-link-row'),
      width = $(window).width(),
      scroll;

  $(window).on('scroll', modifyHeader);

  function modifyHeader() {
    scroll = $(window).scrollTop();

    if ( scroll > 500 ) {
      $(linkHeader).addClass('hidden');
    }
    if ( scroll < 500 ) {
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
      }, {duration: 300, delay: 0, easing: [.24,.63,.5,.99], display: 'none'});

      $(validSuccess).velocity({
        'opacity': [1, 0]
      }, {duration: 300, delay: 350, easing: [.24,.63,.5,.99], display: 'block'});

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

  var html = '<h3>' + title + '</h3>' + msg;

  $(atcModal).append(html);

  function animate() {
    $(atcModal).velocity({
      'opacity': [1, 0],
      'top': [150, 300],
      'z-index': [5000, 5000]
    }, {duration: 400, delay: 0, easing: 'easeInOutSine'});

    $(atcModal).velocity({
      'opacity': [0, 1],
      'top': [300, 150],
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
  var mainImage = $('.main-image img'),
      iFrame = $('body').find('iframe');

  if ( mainImage && mainImage[0] ) {
    if (mainImage[0].complete) {
      handler();
    } else {
      mainImage.load(handler);
    }
  } else {
    return;
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
    setMenuHeight();
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
    var vidUrl = $(vidFrame).attr('data-href');
        if ( vidUrl.indexOf('=') !== -1 ) {
          var vidId = vidUrl.split('='),
              id = vidId[1];
        } else {
          var vidId = vidUrl.split('/');
          id = vidId[3];
        }

    var width = $(window).width(),
        height = (((width/100)*90) / 16) * 9;

    var constructedHtml = '<iframe width="' + width + '" height="' + height + '" src="https://www.youtube.com/embed/' + id + '?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';

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

          setTimeout(function() {
            window.location.href = window.location.href;
          }, 1000);
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

function setMenuHeight() {
  setTimeout(function() {
    var mainMenu = $('body').find('.main-menu'),
        siteContent = $('body').find('.site-content'),
        documentHeight = $('.site-content').height();

     // set menu height, relative to content height (minus footer)
    $(mainMenu).css({
      'height': documentHeight - 325 + 'px'
    });
  }, 1000);
}

var MenuController = function() {
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
          $(mainMenu).removeClass('hidden');
          $(this).addClass('open');
          scrollTo('0px');
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

var CartController = function() {
  var cartIcon = $('body').find('.cart-icon'),
      headerLinkRow = $('body').find('.header-link-row'),
      cartContents = $('body').find('.cart-modal.cart-contents.hidden');

  $(cartIcon).on('click', function(e) {
    if ( headerLinkRow.hasClass('hidden') ) {
      $(cartContents).css({
        'top': 65 + 'px'
      });
    } else {
      $(cartContents).css({
        'top': 95 + 'px'
      });
    }
    $(cartContents).toggleClass('hidden');
  });
}

