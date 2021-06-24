
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
    highlight: ['2021-06-28'],
});



// Fill initial data
const available_days = dcms_new_user.available_days;
const start_date = dcms_new_user.start_date;
const end_date = dcms_new_user.end_date;

console.log(available_days);
console.log(start_date);
console.log(end_date);

// calendar_user.addSelected('2021-06-26');
// calendar_user.addSelected('2021-06-25');
// calendar_user.addSelected('2021-06-20');
// calendar_user.addSelected('2021-06-30');
// calendar_user.addSelected('2021-07-20');

// const fecha = '2021-06-26';
// const x = moment(fecha).locale('es').format('dddd');
// console.log(x);


(function( $ ) {
    'use strict';

    $(calendar_el).click(function(e){

        if ( $(e.target).parent().attr('class') &&
             $(e.target).parent().hasClass('tavo-calendar__day_abs-future') &&
             $(e.target).parent().hasClass('tavo-calendar__day_select') ){

            const day   = $(e.target).text();
            const arr   = $(calendar_el).find('.tavo-calendar__month-label').text().split(', ');
            const month = moment().month(arr[0]).locale('es').format("MM");
            const year  = arr[1];

            console.log(day,month,year);

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

    });

})( jQuery );



// const parts = $('#cal-new-user .tavo-calendar__month-label').text().split(', ');
// const smonth = parts[0];
// const year = parts[1];
// const day = $(this).text();
// const month = moment().month(smonth).locale('es').format("MM");

// console.log(day,month,year);

// calendar_el.addEventListener('calendar-select', (ev) => {
//     alert(calendar_user.getSelected());
//     // calendar_user.addSelected('2021-06-26');
//     // calendar_user.addSelected('2021-06-25');

//     calendar_el.classList.add('sel-date');
// });


