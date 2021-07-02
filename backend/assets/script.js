(function( $ ) {
	'use strict';

    let dcms_object = null;
    let dcms_delete_action = '';
    const spinner = '.lds-ring';
    const btnSave = '#save_res_config';
    const message = $('.cmessage');

    // Tipo de objeto para ambas pantallas, deleted items dcms_res_new_user, dcms_res_change_seats
    if (typeof dcms_res_new_user != "undefined") {
        dcms_object = dcms_res_new_user;
        dcms_delete_action = 'dcms_delete_new_user';
    }
    else if (typeof dcms_res_change_seats != "undefined"){
        dcms_object = dcms_res_change_seats;
        dcms_delete_action = 'dcms_delete_change_seats';
    }

    //Deleted items new user, change seats
    // ------------------------------------
    $('.dcms-table .delete').click(function(e){
        e.preventDefault();

        const row = $(e.target).closest('tr');
        const name = $(e.target).data('name');
        const id = $(e.target).data('id');

        $(row).addClass('remove');
        const confirmation = confirm("¿Estas seguro de eliminar el registro de " + name + "?");

        if ( confirmation ){
            $.ajax({
                url : dcms_object.ajaxurl,
                type: 'post',
                data: {
                    action: dcms_delete_action,
                    nonce   : dcms_object.nonce,
                    id
                }
            })
            .done( function(res) {
                res = JSON.parse(res);
                if (res.status == 0){
                    alert('Hubo algún error, posiblemente el registro no existe');
                } else{
                    $('.dcms-table tr.remove').remove();
                }
            });
        } else {
            $(row).removeClass('remove');
        }

    });

    // Reservation configuration
    // --------------------------
    $(btnSave).click(function(e){
        e.preventDefault();

        const calendar = [];
        let i = -1;
        $('#tbl-calendar input').each(function(){
            const day = $(this).data('day');
            const hour = $(this).data('hour');
            const order = $(this).data('order');
            const qty = $(this).val();

            calendar[++i] = day + '|' + hour + '|' + qty + '|' + order;
        });

        // Type
        const type = $('.nav-tab.nav-tab-active').data('tab');

        // range date
        const range_start = $('#date_start').val();
        const range_end = $('#date_end').val();

        $.ajax({
            url : dcms_res_config.ajaxurl,
            type: 'post',
            data: {
                action:'dcms_save_config',
                nonce   : dcms_res_config.nonce,
                calendar,
                range_start,
                range_end,
                type
            },
            beforeSend: function(){
                $(spinner).show();
                $(btnSave).prop('disabled', true);
                $(message).hide();
            }
        })
        .done( function(res) {
            res = JSON.parse(res);
            show_message(res, message);
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