
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

    if ( available_days.find( day => day.toLowerCase() === day_name.toLowerCase() ) ){
        calendar_user.addSelected(current);
    }

    is_after = moment(current).add(1,'days').isAfter(end_date);
    current = moment(current).add(1,'days').format('YYYY-MM-DD');
}


// Manejamos los eventos con jquery
(function( $ ) {
    'use strict';

    $(calendar_el).click(function(e){

        if ( $(e.target).parent().attr('class') &&
             ( $(e.target).parent().hasClass('tavo-calendar__day_abs-future') || $(e.target).parent().hasClass('tavo-calendar__day_rel-today') ) &&
             $(e.target).parent().hasClass('tavo-calendar__day_select') ){

            const day   = $(e.target).text();
            const arr   = $(calendar_el).find('.tavo-calendar__month-label').text().split(', ');
            const month = moment().month(arr[0]).locale('es').format("MM");
            const year  = arr[1];

            let position = -1;
            let current = 0;

            // Current class
            $(calendar_el).find('.current').removeClass('current');
            $(e.target).addClass('current');

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

    }); // Click



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


