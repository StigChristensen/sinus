import Promise from "bluebird";
import _ from "underscore";
const $ = jQuery || window.jQuery;
const jsonUrlBase = '/wp-content/themes/storefront-child/inc/woocommerce-api/type_';
const jsonUrlEnd = '.json';

let rawData, category, subCat;
let priceLoLower, priceLoUpper, priceMedLower, priceMedUpper, priceHiLower, priceHiUpper;
let sortedByPrice = [];

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

const sortData = (params) => {

  if ( params.indexOf('pris_lav') !== -1 || params.indexOf('pris_med') !== -1 || params.indexOf('pris_top') !== -1 ) {

    let priceSorted = sortByPrice(rawData, params);

    Promise.resolve(priceSorted).then(function(sortedByPrice) {
        return sortByParams(sortedByPrice, params);
    }).then(function(sortedByParams) {
        return getUniqueResults(sortedByParams);
    }).then(function(uniqueResults) {
      console.log(uniqueResults);
      return true;
    });

  } else {
    let paramsSorted = sortByParams(rawData, params);
    let getUnique = getUniqueResults(paramsSorted);
  }

  // console.log(getUnique);
}

const sortByPrice = (data, params) => {

  let length = data.length, i = 0, highest, lowest = 0;

  console.log(length);

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

  if ( params.indexOf('pris_med') !== -1 ) {
    lowest = priceMedLower;
  }

  if ( params.indexOf('pris_top') !== -1 ) {
    lowest = priceHiLower;
  }

  for (i; i < length; i++) {
    let price = parseInt(data[i].price);

    if ( price < highest && price > lowest ) {
      sortedByPrice.push(data[i]);
    }
  }

  return sortedByPrice;

}

const sortByParams = (data, params) => {
  let sortedByParams = [];
  let length = data.length, i = 0;

  for (i; i < length; i++) {
    let categoriesLength = data[i].categories.length,
        categories = data[i].categories,
        k = 0;

        for (k; k < categoriesLength; k++) {
          if ( params.indexOf(categories[k].toLowerCase()) !== -1 ) {
            sortedByParams.push(data[i]);
          }
        }
  }

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

const renderTemplate = (sortedData) => {

}

const addFilterListener = () => {
  $('body').on('click', '.filter-button', function(event) {

    Promise.resolve(getSortParams()).then(function(params) {
      // console.log(params);

      if ( params.length > 0 ) {
        return sortData(params);
      } else {
        return false;
      }

    }).then(function(uniqueResults) {
      // console.log(uniqueResults);
      if ( uniqueResults !== false ) {
        animateOut();
      } else {
        return;
      }
    });
  });
}

const animateOut = () => {
  let products = $('body').find('li.product');

  $(products).each(function(i,e) {
    $(e).fadeOut(500);
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
    console.log('ready');
    setPriceRanges();
    // console.log('data ----> ', rawData);
  });

  const listen = new addFilterListener();
});
