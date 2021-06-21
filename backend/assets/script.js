(function( $ ) {
	'use strict';

    const spinner = '.lds-ring';
    const btnSave = '#save_res_config';

    $(btnSave).click(function(e){
        e.preventDefault();


        $.ajax({
            url : dcms_res_config.ajaxurl,
            type: 'post',
            data: {
                action:'dcms_save_config',
                nonce:'',
                enviar: 'ok'
            },
            beforeSend: function(){
                $(spinner).show();
                $(btnSave).prop('disabled', true);
                // $(smessage).hide();
                // $('#save_res_config').prop('disabled',true);
            }
        })
        .done( function(res) {
            res = JSON.parse(res);
            console.log(res);
            // show_message(res, container);
        })
        .always( function() {
            $(spinner).hide();
            $(btnSave).prop('disabled',false);
        });


    });



    // Aux function to show message
    function show_message(res, container){
        if (res.status == 0 ) {
            $(container).addClass('error');
        } else {
            $(container).removeClass('error');
        }
        $(container).show().html(res.message);
    }

})( jQuery );