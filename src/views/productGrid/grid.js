import Promise from "bluebird";
// import _ from "underscore";
const $ = jQuery || window.jQuery;
const jsonUrlBase = '/wp-content/themes/storefront-child/inc/woocommerce-api/type_';
const jsonUrlEnd = '.json';

let rawData, category, subCat;
let priceLoLower, priceLoUpper, priceMedLower, priceMedUpper, priceHiLower, priceHiUpper;

const setPriceRanges = () => {
  let priceLow = $('input.pris_lav').data('range'),
      priceMed = $('input.pris_med').data('range'),
      priceHi = $('input.pris_top').data('range');

  let lowParts = priceLow.split('-'),
      medParts = priceMed.split('-'),
      hiParts = priceHi.split('-');

  priceLoLower = lowParts[0];
  priceLoUpper = lowParts[1];
  priceMedLower = medParts[0];
  priceMedUpper = medParts[1];
  priceHiLower = hiParts[0];
  priceHiUpper = hiParts[1];
}

const getURI = (category) => {
  let lower;

  if ( category.indexOf(" ") !== -1 ) {
    let parts = category.split(" ");
    lower = parts[0].toLowerCase();
  } else {
    lower = category.toLowerCase();
  }

  let uri = jsonUrlBase + lower + jsonUrlEnd;
  return uri;
}

const getSortParams = () => {
  let inputs = $('input:checked'),
      params = [];

  $(inputs).each(function(i,e) {
    if ( $(e).attr('checked') ) {
      let param = $(e).attr('name');
      params.push(param);
    }
  });

  return params;
}

const getData = (uri) => {
  return $.getJSON(uri, function(response) {
    return response;
  });
}

const addFilterListener = () => {
  let ulProducts = $('body').find('ul.products'),
      filtersInfo = $('body').find('.filters-info-box');

  $('body').on('click', '.filter-button', function(event) {
    let params = getSortParams();

    if ( params.length > 0 ) {
      let results = sortData(params);

      Promise.resolve(results).then((uniqueResults) => {
        // console.log("Returned: ", uniqueResults.length);

        if ( uniqueResults && uniqueResults.length !== 0 ) {
          animateOut();

          if ( !$(filtersInfo).hasClass('not-expanded') ) {
            $(filtersInfo).addClass('not-expanded');
          }

          $(uniqueResults).each((i,e) => {
            let product = renderTemplate(e);

            Promise.resolve(product).then((productTemplate) => {
              $(ulProducts).append(productTemplate);
              return Promise.resolve(productTemplate);
            });

          });

          return Promise.resolve(true);

        } else {
          $(filtersInfo).removeClass('not-expanded');
          Promise.reject(false);
        }
      }).catch(TypeError, (e) => {
        console.log('TypeError: ', e);
      }).catch(ReferenceError, (e) => {
        console.log('ReferenceError: ', e);
      }).catch((e) => {
        console.log('Error: ', e);
      });

    } else {
      return false;
    }
  });
}

const sortData = (params) => {
  let priceSort, paramsSort, uniqSort;

  if ( params.indexOf('pris_lav') !== -1 || params.indexOf('pris_med') !== -1 || params.indexOf('pris_top') !== -1 ) {
    priceSort = sortByPrice(rawData, params);

    uniqSort = Promise.resolve(priceSort).then(function(sortedByPrice) {
        return sortByParams(sortedByPrice, params);
    }).then(function(sortedByParams) {
        return getUniqueResults(sortedByParams);
    }).catch((e) => {
      console.log(e);
    });;

  } else {
    paramsSort = sortByParams(rawData, params);

    uniqSort = Promise.resolve(paramsSort).then((paramsSorted) => {
      return getUniqueResults(paramsSorted);
    }).catch((e) => {
      console.log(e);
    });
  }

  return uniqSort;
}

const sortByPrice = (data, params) => {
  let sortedByPrice = [];

  let length = data.length, i = 0, highest, lowest = 0;

  if ( params.indexOf('pris_top') !== -1 ) {
    highest = priceHiUpper;
  }

  if ( params.indexOf('pris_med') !== -1 && params.indexOf('pris_top') === -1 ) {
    highest = priceMedUpper;
  }

  if ( params.indexOf('pris_lav') !== -1 && params.indexOf('pris_med') === -1 ) {
    highest = priceLoUpper;
  }

  if ( params.indexOf('pris_lav') !== -1 ) {
    lowest = 0;
  }

  if ( params.indexOf('pris_med') !== -1 && params.indexOf('pris_lav') === -1 ) {
    lowest = priceMedLower;
  }

  if ( params.indexOf('pris_top') !== -1 && params.indexOf('pris_med') === -1 ) {
    lowest = priceHiLower;
  }

  for (i; i < length; i++) {
    let price = parseInt(data[i].price);

    if ( price < highest && price > lowest ) {
      sortedByPrice.push(data[i]);
    }
  }

  // console.log("Price sort length: ", sortedByPrice.length);
  return sortedByPrice;
}

const sortByParams = (data, params) => {
  let sortedByParams = [];
  let length = data.length, i = 0;

  let filteredParams = params.filter((val) => {
    if ( val.indexOf('pris_') ) {
      return val;
    }
  });

  let paramLength = filteredParams.length;

  for (i; i < length; i++) {
    let categoriesLength = data[i].categories.length,
        categories = data[i].categories,
        matches = [],
        k = 0;

        for (k; k < categoriesLength; k++) {

          if ( filteredParams.indexOf(categories[k].toLowerCase()) !== -1 ) {
            matches.push(categories[k]);
          }
        }

    if ( matches.length === paramLength ) {
      sortedByParams.push(data[i]);
    }
  }

  // console.log("Sorted by params: ", sortedByParams.length);
  return sortedByParams;
}

const getUniqueResults = (data) => {
  let seen = {},
      uniqueResults = [];

  // filter out duplicates by id
  function uniqueId(obj) {
    return obj.hasOwnProperty(obj.id) ? false : (seen[obj.id] = true);
  }

  uniqueResults = data.filter(uniqueId);

  let filterData = Promise.resolve(uniqueResults).then((uniq) => {
    console.log(uniq.length);
    return Promise.resolve(uniq);
  })

  return filterData;
}



const animateOut = () => {
  let products = $('body').find('li.product');

  $(products).each(function(i,e) {
    $(e).fadeOut(500);

    setTimeout(() => {
      $(e).remove();
    }, 600);
  });
}

const highLightSub = (category) => {
  if ( category !== 'hovedtelefoner' ) {
    return;
  } else {
    let inputs = $('body').find('input');

    $(inputs).each(function(i,e) {
      if ( $(e).hasClass(subCat) ) {
        $(e).prop('checked', true);
      }
    });
  }
}

$(document).on('ready', function() {
  let container = $('body').find('.products-container'),
      type = $(container).data('templatetype').toLowerCase();
      category = $(container).data('category').toLowerCase();
      subCat = $(container).data('subcat').toLowerCase();

  highLightSub(category);

  Promise.resolve(getURI(category)).then(function(uri) {
    return getData(uri);
  }).then(function(data) {
    rawData = data;
    setPriceRanges();
    const listen = new addFilterListener();
  }).catch((e) => {
    console.log(e);
  });


});

function renderTemplate(e) {
  let stockIcon, template, stockClass;

  if ( e.stock_quantity === 0 ) {
    stockIcon = '<div class="in-stock-icon"><span>PÅ LAGER: <i class="fa fa-minus-square"></i></span></div>';
    stockClass = 'stock-false';
  }

  if ( e.stock_quantity > 0 ) {
    stockIcon = '<div class="in-stock-icon"><span>PÅ LAGER: <i class="fa fa-check-square"></i></span></div>';
    stockClass = 'stock-true';
  }

  let desc = e.description;
  let stripped = desc.replace(/<(?:.|\n)*?>/gm, '');

  template = '<li class="product ' + stockClass + '" itemscope itemtype="http://schema.org/Product" data-singleid="' + e.id + '">';
      template += '<a href="' + e.permalink + '"<div class="click-area"></div></a>';
      template += stockIcon;
      template += '<img src="' + e.featured_src + '" alt="' + e.title + ' product image produkt billede Sinus-store Copenhagen København Denmark" />';
      template += '<div class="product-title" itemprop="name"><h3>' + e.title + '</h3></div>';
      template += '<div class="product-price">' + e.price_html + '<div class="add-button" data-href="' + e.id + '" data-title="' + e.title + '"><svg version="1.1" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"x="0px" y="0px" viewBox="0 0 60 60" xml:space="preserve"><line class="svg-line" fill="none" stroke="#007c96" stroke-width="10" stroke-miterlimit="10" x1="30" y1="6" x2="30" y2="54"/><line class="svg-line" fill="none" stroke="#007c96" stroke-width="10" stroke-miterlimit="10" x1="6" y1="30" x2="54" y2="30"/></svg><span class="add-info">Tilføj til kurv</span></div></div>';
      template += '<div class="sinus-product-info"><div class="short-desc" itemprop="description"><p>' + stripped.split(" ").splice(0, 26).join(" ") + '... </p><i class="fa fa-chevron-circle-up"></i></div></div>';
      template += '</li>';

  return template;
};
