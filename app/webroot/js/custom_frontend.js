jQuery(document).on('click', '.hover-action', function () {
    jQuery(this).toggleClass('active');
});
function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

jQuery(document).on('click', '.cookie-popup>.content>a.accept', function (e) {
    e.preventDefault();
    jQuery('.cookie-popup').hide();
    createCookie('cookie-popup', 1, 300);
});
jQuery(document).on('click', '.block-on-send', function () {
    jQuery('.loading-content').show();
});
jQuery(document).on('click', '.cms-section.section-faq h6', function () {
    jQuery(this).next().slideToggle(400);
    jQuery(this).toggleClass('active');
});

jQuery(document).on('click', '.goto', function (e) {

    var href = jQuery(this).attr('href');
    if (jQuery(href).length > 0) {
        e.preventDefault();
        jQuery('html, body').animate({scrollTop: jQuery(href).offset().top}, 'slow');
    } else {

    }
});
function bannerHeight() {
    var height = jQuery(window).height();
    var heading = parseInt(jQuery('#bmain-nav').css('height'));
    console.log('asdas' + height + ' ' + heading);
    jQuery('.banner-homepage img').css('top', '-' + heading + 'px');
    jQuery('.banner-homepage img').css('max-height', height + 'px');
    jQuery('.banner-homepage').css('height', (height - heading) + 'px');
}
function fullpage() {
    var height = jQuery(window).height();
    var width = jQuery(window).width();
    var heading = parseInt(jQuery('.fullpage .big-heading').css('height')) + parseInt(jQuery('.fullpage .big-heading').css('margin-bottom'))
    console.log('asdas');

    jQuery('.fullpage .tile').css('height', (height - 150 - heading) + 'px');
}
jQuery(window).load(function () {
    bannerHeight();
});
jQuery(window).resize(function () {
    bannerHeight();
});
jQuery(document).ready(function () {
    //fullpage();

    bannerHeight();


    console.log('asdas');

    jQuery(".owl-slider").owlCarousel({
        items: 4,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [979, 3],
        itemsTablet: [768, 2],
        itemsMobile: [429, 1],
        paginationSpeed: 400,
        singleItem: false,
        stopOnHover: true,
        pagination: true,
        autoPlay: 4000,
        navigation: false,
        navigationText: ['<i class="fa fa-arrow-left"></i>', '<i class="fa fa-arrow-right"></i>']
    });
});