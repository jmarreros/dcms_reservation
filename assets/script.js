// Manejamos los eventos con jquery
(function( $ ) {
    'use strict';

    let calendar_el = null; // calendar element
    let dcms_object = null; // dcms_new_user, dcms_change_seats
    let select_day  = ''; // Select day from calendar
    let select_hour = ''; // select specific hour

    // Config calendar for new users
    if (typeof dcms_new_user != "undefined") {

        dcms_object = dcms_new_user;
        calendar_el = document.querySelector('#cal-new-user');
        const calendar_control = new TavoCalendar(calendar_el, {
            range_select: false,
            selected: [],
            locale: 'es',
            multi_select: false,
            future_select: true,
            past_select: false,
            frozen: true,
        });

        initialization( calendar_control );
    }


    function initialization(calendar_control){
        // Fill initial data
        const available_days = dcms_object.available_days;
        const start_date = dcms_object.start_date;
        const end_date = dcms_object.end_date;

        // Marcamos los dias disponibles
        let is_after = false;
        let current = start_date;
        while ( ! is_after ){

            const day_name = moment(current).locale('es').format('dddd');

            if ( available_days.includes( day_name ) ){
                calendar_control.addSelected(current);
            }

            is_after = moment(current).add(1,'days').isAfter(end_date);
            current = moment(current).add(1,'days').format('YYYY-MM-DD');
        }
    }

    $(calendar_el).click(function(e){

        // Para la seleccion de días
        if ( $(e.target).parent().attr('class') &&
             ( $(e.target).parent().hasClass('tavo-calendar__day_abs-future') || $(e.target).parent().hasClass('tavo-calendar__day_rel-today') ) &&
             $(e.target).parent().hasClass('tavo-calendar__day_select') ){

            const day   = $(e.target).text();
            const arr   = $(calendar_el).find('.tavo-calendar__month-label').text().split(', ');
            const month = moment().month(arr[0]).locale('es').format("MM");
            const year  = arr[1];

            let position = -1;
            let current = 0;

            select_day = year + '-' +month + '-' + day;
            // Call select day
            get_data_per_day(select_day);

            // Current class
            $(calendar_el).find('.current').removeClass('current');
            $(e.target).addClass('current').parent().addClass('current');

            $('.tavo-calendar__days .cal-sel-date').remove();

            // recorremos el array para saber la posicion e insertar el detalle de Horas
            $(calendar_el).find('.tavo-calendar__day').each(function(index, item){
                current = index + 1;
                if ( $(item).find('.tavo-calendar__day-inner').text() == day ){
                    position = current;
                }
                if ( position > 0 ){
                    if ( current % 7 == 0){
                        $('.cal-container > .cal-sel-date').clone().insertAfter($(item));
                        return false;
                    }
                }
            })

        }

        // para la selección de elementos en la lista
        if ( $(e.target).is('li') && $(e.target).data('hour') ){
            const sel_hour = $(e.target).data('hour');
            $('.available-hours li').removeClass('selected');
            $(e.target).addClass('selected');
        }

    }); // Click

    // get days ajax
    function get_data_per_day(selected_day){

        const template = "<li data-hour='{hour}'>🕒 {hour} <span>{cupos} cupos disponibles</span></li>";
        const dayname = moment(selected_day).locale('es').format('dddd');

        $.ajax({
            url: dcms_object.ajaxurl,
            type: 'post',
            dataType: 'json',
            data: {
                action:'dcms_get_available_hours',
                nonce: dcms_object.nonce,
                type: $(calendar_el).attr('id'),
                date: selected_day,
                dayname
            },
            beforeSend: function(){
                $('.cal-sel-date .available-hours li').remove();
                $('.cal-sel-date .waiting').show();
                $('.cal-sel-date .no-data').hide();
            }
        })
        .done( function(res){
            if ( $.isEmptyObject(res) ){
                $('.cal-sel-date .no-data').show();
            } else {

                for (const hour in res) {
                    const cupos = res[hour];
                    const str = template.replaceAll('{hour}', hour).replaceAll('{cupos}', cupos);

                    $('.cal-sel-date .available-hours').append(str);
                }
            }

        })
        .always( function(){
            $('.cal-sel-date .waiting').hide();
        }); // ajax
    } // get_data_per_day


    // Save new users
    // ----------------------------------------------------------------

    // Ajax save new user

    $('#frm-new-users').submit(function(e){
        e.preventDefault();

        const sspin     = '.frm-new-users > .lds-ring';
        const sbutton   = '.frm-new-users #send.button';
        const smessage  = '.frm-new-users section.message';


        // day hour validation
        if ( $('.frm-new-users .available-hours li.selected').length ){
            select_hour = $('.frm-new-users .available-hours li.selected').data('hour');
        } else {
            show_message({
                status:0,
                message: 'Tienes que seleccionar una fecha y hora'
            }, smessage);
            return false;
        }


        $.ajax({
			url : dcms_object.ajaxurl,
			type: 'post',
			data: {
				action  : 'dcms_save_new_user',
                nonce   : dcms_object.nonce,
                name    : $('#name').val(),
                lastname: $('#lastname').val(),
                dni     : $('#dni').val(),
                email   : $('#email').val(),
                phone   : $('#phone').val(),
                select_day,
                select_hour
			},
            beforeSend: function(){
                $(sspin).show();
                $(sbutton).val('Enviando ...').prop('disabled', true);;
                $(smessage).hide();
            }
        })
        .done( function(res) {
            res = JSON.parse(res);
            show_message(res, smessage);
        })
        .always( function() {
            $(sspin).hide();
            $(sbutton).val('Enviar').prop('disabled', false);;
        });


    });


    //Aux Functions
    // ----------------------------------------------------------------

    // Aux function to show message
    function show_message(res, cmessage){
        if (res.status == 0 ) {
            $(cmessage).addClass('error');
        } else {
            $(cmessage).removeClass('error');
        }

        $(cmessage).show().html(res.message);
    }

})( jQuery );

