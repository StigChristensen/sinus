import Promise from "bluebird";
import _ from "underscore";
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
  let inputs = $('input[type=checkbox]:checked'),
      params = [];

  $(inputs).each(function(i,e) {
    let param = $(e).attr('name');
    params.push(param);
  });

  return params;
}

const getData = (uri) => {
  return $.get(uri, function(response) {
    return response;
  });
}

const addFilterListener = () => {
  let ulProducts = $('body').find('ul.products');

  $('body').on('click', '.filter-button', function(event) {
    let params = getSortParams();

    if ( params.length > 0 ) {
      let results = sortData(params);

      Promise.resolve(results).then((uniqueResults) => {
        // console.log(uniqueResults);

        if ( uniqueResults && uniqueResults.length !== 0 ) {
          animateOut();

          $(uniqueResults).each((i,e) => {
            let product = renderTemplate(e);
            Promise.resolve(product).then((productTemplate) => {
              $(ulProducts).append(productTemplate);
            });
          });

        } else {
          console.log('No results found - handle this!');
        }
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
    });

  } else {
    paramsSort = sortByParams(rawData, params);

    uniqSort = Promise.resolve(paramsSort).then((paramsSorted) => {
      return getUniqueResults(paramsSorted);
    });
  }

  // console.log(uniqSort.length);
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

  // console.log(sortedByPrice.length);
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

  // console.log(sortedByParams.length);
  return sortedByParams;
}


const getUniqueResults = (data) => {
  let uniqueResults = [];

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

  let getTopHits = data.sort(sortByFrequency(data));
  let uniq = _.uniq(getTopHits, true);

  return uniq;
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

const highLightSub = () => {
  let subCheck = $('input[type=checkbox].' + subCat);

  $(subCheck).prop('checked', true);
}

$(document).on('ready', function() {
  let container = $('body').find('.products-container'),
      type = $(container).data('templatetype').toLowerCase();
      category = $(container).data('category').toLowerCase();
      subCat = $(container).data('subcat').toLowerCase();

  highLightSub();

  Promise.resolve(getURI(category)).then(function(uri) {
    return getData(uri);
  }).then(function(data) {
    rawData = data;
    setPriceRanges();
  });

  const listen = new addFilterListener();
});

function renderTemplate(e) {
  let stockIcon, template, stockClass;

  function prepare() {
    if ( e.stock_quantity === 0 ) {
      stockIcon = '<div class="in-stock-icon"><span>PÅ LAGER: <i class="fa fa-minus-square"></i></span></div>';
      stockClass = 'stock-false';
    }

    if ( e.stock_quantity > 0 ) {
      stockIcon = '<div class="in-stock-icon"><span>PÅ LAGER: <i class="fa fa-check-square"></i></span></div>';
      stockClass = 'stock-true';
    }
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

    prepare();
    return template;
};
