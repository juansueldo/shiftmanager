import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import allLocales from '@fullcalendar/core/locales-all';
const base_url = 'http://127.0.0.1:8000';

function initializeCalendar(calendarElement, lang) {
    // Obtener los eventos desde el atributo data-ajax-data
    var eventsData = calendarElement.getAttribute('data-ajax-data');
    var events = JSON.parse(eventsData);

    var calendar = new Calendar(calendarElement, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        locales: allLocales,
        locale: lang,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        themeSystem: 'bootstrap5',
        events: events, // Pasar los eventos cargados dinámicamente
        eventClick: function(info) {
            var eventId = info.event.id;
            var url = base_url + '/calendar/add/' + eventId;
            var container = '#offcanvasEnd';
            updatePart(url, null, container, 'GET');
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasEnd'));
            offcanvas.show();
        }
    });
    calendar.render();
}

window.initializeCalendar = initializeCalendar;