module.exports = function renderTemplate(e) {
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

    let desc = e.description;
    let stripped = desc.replace(/<(?:.|\n)*?>/gm, '');

  let template = '<li class="product ' + stockClass + '" itemscope itemtype="http://schema.org/Product" data-singleid="' + e.id + '">';
      template += '<div class="click-area"></div>';
      template += stockIcon;
      template += '<img src="' + e.featured_src + '" alt="' + e.title + ' product image produkt billede Sinus-store Copenhagen København Denmark" />';
      template += '<div class="product-title" itemprop="name"><h3>' + e.title + '</h3></div>';
      template += '<div class="product-price">' + e.price_html + '<div class="add-button" data-href="' + e.id + '" data-title="' + e.title + '"><svg version="1.1" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"x="0px" y="0px" viewBox="0 0 60 60" xml:space="preserve"><line class="svg-line" fill="none" stroke="#007c96" stroke-width="10" stroke-miterlimit="10" x1="30" y1="6" x2="30" y2="54"/><line class="svg-line" fill="none" stroke="#007c96" stroke-width="10" stroke-miterlimit="10" x1="6" y1="30" x2="54" y2="30"/></svg><span class="add-info">Tilføj til kurv</span></div></div>';
      template += '<div class="sinus-product-info"><div class="short-desc" itemprop="description"><p>' + stripped.split(" ").splice(0, 26).join(" ") + '... </p><i class="fa fa-chevron-circle-up"></i></div></div>';
      template += '</li>';
    }

    prepare();
    return template;
};
