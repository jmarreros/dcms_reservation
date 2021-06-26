
// Config calendar
const calendar_el = document.querySelector('#cal-new-user');
const calendar_user = new TavoCalendar(calendar_el, {
    range_select: false,
    selected: [],
    locale: 'es',
    multi_select: false,
    future_select: true,
    past_select: false,
    frozen: true,
});

// Fill initial data
const available_days = dcms_new_user.available_days;
const start_date = dcms_new_user.start_date;
const end_date = dcms_new_user.end_date;

// Marcamos los dias disponibles
let is_after = false;
let current = start_date;
while ( ! is_after ){

    const day_name = moment(current).locale('es').format('dddd');

    if ( available_days.includes( day_name ) ){
        calendar_user.addSelected(current);
    }

    is_after = moment(current).add(1,'days').isAfter(end_date);
    current = moment(current).add(1,'days').format('YYYY-MM-DD');
}


// Manejamos los eventos con jquery
(function( $ ) {
    'use strict';

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

            const select_day = year + '-' +month + '-' + day;
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

        const dayname = moment(selected_day).locale('es').format('dddd');

        $.ajax({
            url: dcms_new_user.ajaxurl,
            type: 'post',
            dataType: 'json',
            data: {
                action:'dcms_get_available_hours',
                nonce: dcms_new_user.nonce,
                type: $(calendar_el).attr('id'),
                date: selected_day,
                dayname
            },
            beforeSend: function(){

            }
        })
        .done( function(res){
            console.log(res);
        })
        .always( function(){

        });

        ;
    }

    // $.ajax({
    //     url : dcms_flogin.ajaxurl,
    //     type: 'post',
    //     data: {
    //         action  : 'dcms_ajax_validate_login',
    //         nonce   : dcms_flogin.nonce,
    //         username: $('#username').val(),
    //         password: $('#password').val(),
    //     },
    //     beforeSend: function(){
    //         $(sspin).show();
    //         $(sbutton).val('Validando ...').prop('disabled', true);;
    //         $(smessage).hide();
    //     }
    // })
    // .done( function(res) {
    //     res = JSON.parse(res);
    //     show_message(res, smessage);

    //     if (res.status == 1){
    //         window.location.href = dcms_flogin.url;
    //     }
    // })
    // .always( function() {
    //     $(sspin).hide();
    //     $(sbutton).val('Ingresar').prop('disabled', false);;
    // });


})( jQuery );



// Todo:
// 1- foreach de todas las fechas desde el start_date hasta el end_date
// 2- Comparar si la fecha esta dentro del get_available_days
// 3- Al hacer click en una fecha, mostrar los horarios habilitados
// 4- Para mostrar los horarios tengo que sumar los horarios existentes en esa mismo día y hora
// 5- Sino la cantidad agrupada sobrepasa la configuracíon de hora día, entonces no se mostrará

// console.log(available_days); // lunes, martes, miercoles, jueves, viernes, sabado
// console.log(start_date);
// console.log(end_date);

// calendar_user.addSelected('2021-06-26');
// const fecha = '2021-06-26';
// const x = moment(fecha).locale('es').format('dddd');
// console.log(x);


