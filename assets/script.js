const calendar_el = document.querySelector('#cal-new-user');
const calendar_user = new TavoCalendar('#cal-new-user', {
    range_select: false,
    selected: [],
    locale: 'es',
    multi_select: false,
    future_select: true,
    past_select: false,
    frozen: true,
    highlight: ['2021-06-28'],
});

calendar_user.addSelected('2021-06-26');
calendar_user.addSelected('2021-06-25');


(function( $ ) {
    'use strict';

    $('#cal-new-user').click(function(e){

        if ( $(e.target).parent().attr('class') && $(e.target).parent().attr('class').includes('tavo-calendar__day_select') ){
            const day   = $(e.target).text();
            const arr   = $('#cal-new-user .tavo-calendar__month-label').text().split(', ');
            const month = moment().month(arr[0]).locale('es').format("MM");
            const year  = arr[1];

            console.log(day,month,year);
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


