function masonrySET() {
    var container = jQuery('.masonry-container');

    container.masonry({
        columnWidth: '.item',
        itemSelector: '.item',
        isAnimated: true

    });

}
jQuery(document).on('click', '.post', function () {

    console.log('sadsads');
    jQuery(this).prepend('<i class="fa fa-circle-o-notch fa-spin  fa-fw"></i>');
    jQuery(this).attr('disabled', true);
});
jQuery(document).ready(function () {

    /* Only register a service worker if it's supported */
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('service-worker.js');
    }

    if (jQuery('.load-ajax').length > 0) {
        console.log('www');
        jQuery('.load-ajax').each(function () {
            console.log('sadsasd');
            var url = jQuery(this).attr('data-url');
            var id = jQuery(this).attr('data-id');
            jQuery(this).load(url, function () {
                console.log('loaded');
               jQuery(this).load(url +' #ppppp', function () {
                console.log('loaded');
               
            });
            });
            

        });
    }
    masonrySET();


    setTimeout(
            function ()
            {
                jQuery('#flashMessage').fadeOut(400);
            }, 5000);

    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 100) {
            jQuery('.scrollToTop').fadeIn();
        } else {
            jQuery('.scrollToTop').fadeOut();
        }
    });
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 150) {
            jQuery('.navbar.navbar-default').addClass('sticky');
        } else {
            jQuery('.navbar.navbar-default').removeClass('sticky');
        }
    });
    jQuery('.scrollToTop').click(function () {
        jQuery('html, body').animate({scrollTop: 0}, 800);
        return false;
    });

});