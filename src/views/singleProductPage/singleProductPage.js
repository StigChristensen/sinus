const $ = jQuery;

$(document).on('ready', () => {
  addEventListener();
});

const addEventListener = ()=> {
  let mainImage = $('body').find('.main-image');

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

  $('body').on('click', '.main-image', (e) => {
    let parent = $(e.target).parents('.main-image'),
        fullImgSrc = $(parent).data('fullsrc');

    let html = '<div class="large-image-modal hidden"><span class="tooltip">Klik hvor som helst for at lukke</span><img src="' + fullImgSrc +'" /></div>';

    $('body').append(html);

    setTimeout( () => {
      $('.large-image-modal').removeClass('hidden');
      new modalListener();
    }, 100);

    let modalListener = () => {
      $('body').on('click', '.large-image-modal', () => {
         $('.large-image-modal').addClass('hidden');

         setTimeout( () => {
           $('.large-image-modal').html('');
           $('body').remove('.large-image-modal');
           modalListener = null;
         }, 700);
      });
    }

  });

}
