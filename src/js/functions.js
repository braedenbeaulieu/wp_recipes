jQuery(function($) {
"use strict"

    $('[data-toggle]').on('click', function(e) {
        let className = $(this).data('toggle');

        console.log(className);
        $(this).toggleClass(className);
    });

    if($('[data-colour]').length) {
        $('[data-colour]').each(index => {
            // console.log($(this).text());
            // let colour = $(this).data('colour');

            // console.log(colour);
            // $(this).css('background', colour);
        });
    }

    if($('.i_made_it').length) {
        if(getCookie('made_it')) {
            $('.i_made_it').addClass('yes').children('p').text('You made it!');
        }

        $('.i_made_it').click( function(e) {
            e.preventDefault(); 

            if(!getCookie('made_it')) {
                console.log('doesnt have cookie');
                $('.rp-made-it-popup').addClass('open');


                let post_id = $(this).attr('data-post_id');
                let nonce = $(this).attr('data-nonce');
                $.ajax({
                    type : 'post',
                    dataType : 'json',
                    url : localized_vars.ajaxurl,
                    data : {
                        action: 'made_it', 
                        post_id : post_id, 
                        nonce: nonce
                    },
                    success: res => {
                        // set a cookie so they cant keep pressing it!
                        let cookieExpire = new Date();
                        cookieExpire.setMonth(cookieExpire.getMonth() + 10);
                        document.cookie = "made_it=true; expires="+ cookieExpire.toGMTString() + ";";
                        // add 1 to the counter
                        $('.made-it-counter').text(parseInt($('.made-it-counter').text()) + 1);
                        $('.i_made_it').addClass('yes').children('p').text('You made it!');
                    },
                    error: err => {
                        console.log(err);
                    }
                });
            } else {
                console.log('has cookie');
            }
        });
    }

});

function getCookie(name) {
    var regexp = new RegExp("(?:^" + name + "|;\s*"+ name + ")=(.*?)(?:;|$)", "g");
    var result = regexp.exec(document.cookie);
    return (result === null) ? null : result[1];
}