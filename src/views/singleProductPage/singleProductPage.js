const $ = jQuery;

$(document).on('ready', ()=> {
  addEventListener();
  addClasses();
});

const addEventListener = ()=> {
  let mainImage = $('body').find('.main-image'),
      width = $(window).width();

  $('body').on('click', '.product-image', function(e) {
    let parent = $(e.target).parents('.product-image'),
        origThumbSrc = $(parent).data('fullsrc'),
        newThumbSrc = $(mainImage).data('fullsrc');

    let mainHtml = '<img src="' + origThumbSrc + '" />',
        thumbHtml = '<img src="' + newThumbSrc + '" />';

    $(mainImage).html(mainHtml);
    $(parent).html(thumbHtml);

    $(mainImage).data('fullsrc', origThumbSrc);
    $(parent).data('fullsrc', newThumbSrc);
  });

  if ( width > 550 ) {
    largeImgModal();
  }

  $(window).resize(() => {
    let newWidth = $(window).width();
    clearInterval(resizeInterval);

    let resizeInterval = setTimeout(() => {
      if ( newWidth > 550 ) {
        largeImgModal();
      } else {
        largeImgModalDisable();
      }
    }, 1000);

  });

  function largeImgModal() {
    console.log('enabled');

    $('body').on('click', '.main-image', (e) => {
      let fullImgSrc;

      if ( $(e.target).is('img') ) {
        let parent = $(e.target).parents('.main-image');
        fullImgSrc = $(parent).data('fullsrc');
      } else {
        fullImgSrc = $(e.target).data('fullsrc');
      }

      let html = '<div class="large-image-modal hidden"><span class="tooltip">Klik hvor som helst for at lukke</span><img src="' + fullImgSrc +'" /></div>';

      $('body').append(html);

      setTimeout( ()=> {
        $('.large-image-modal').removeClass('hidden');
        new modalListener();
      }, 100);

      let modalListener = ()=> {
        $('body').on('click', '.large-image-modal', () => {
           $('.large-image-modal').addClass('hidden');

           setTimeout( ()=> {
             $('.large-image-modal').html('');
             $('.large-image-modal').remove();
             modalListener = null;
           }, 700);
        });
      }

    });
  }

  function largeImgModalDisable() {
    console.log('disabled');
    $('body').off('click', '.main-image');
  }
}

const addClasses = () => {
  let imgCntrl = $('body').find('.images-cntrl'),
      singleImage = $('body').find('.single-image-cntrl'),
      productContent = $('body').find('.product-content');

      if ( imgCntrl.length !== 0 ) {
        $(productContent).addClass('mobile-add-padding');
      }

      if ( singleImage.length !== 0 ) {
        $(productContent).addClass('mobile-remove-padding');
      }
}
