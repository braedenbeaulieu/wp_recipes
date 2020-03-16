jQuery(function($) {
"use strict"

    if($('.rp-made-it-popup').length) {
        $('.close-popup').on('click', function() {
            $('.rp-made-it-popup').removeClass('open');
        });
    }

});