/**
 * Created by fernando on 24/06/16.
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var zone = "03:00";  //timezone
var currentMousePos = {
    x: -1,
    y: -1
};
$(document).ready(function () {

    $.ajax({
        url: 'reservation',
        type: 'GET',
        data: '',
        async: false,
        success: function (response) {
            $.each(response, function (index, room) {

                var reservation = [];
                $.each(room.reservation, function (index, reserv) {
                    reservation.push(reserv);
                });
                initCalendar(room.id, reservation);
            });

        }
    });

    jQuery(document).on("mousemove", function (event) {
        currentMousePos.x = event.pageX;
        currentMousePos.y = event.pageY;
    });

    /* initialize the external events
     -----------------------------------------------------------------*/

    $('.external-events .fc-event').each(function () {

        // store data so the calendar knows to render an event upon drop
        $(this).data('event', {
            title: $.trim('Reservado para ' + $(this).data('name')) + ' - (Clique para editar)', // use the element's text as the event title
            stick: true // maintain when user navigates (see docs on the renderEvent method)
        });

        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true,      // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
        });

    });


});

function initCalendar(idRoom, reservation) {
    $('#calendar_room_' + idRoom).fullCalendar({
        events: reservation,
        //events: [{"id":"14","title":"New Event","start":"2016-06-25","allDay":false}],
        utc: true,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'agendaDay, agendaWeek, month'
        },
        editable: true,
        droppable: true,
        slotDuration: '01:00:00',
        snapDuration: '01:00:00',
        defaultView: 'agendaDay',
        slotEventOverlap: false,
        forceEventDuration: true,
        defaultTimedEventDuration: '01:00:00',
        eventOverlap: false,
        firstDay: 1,
        axisFormat: 'HH:mm',
        timeFormat: {
            agenda: 'HH:mm'
        },
        allDaySlot: false,
        eventReceive: function (event) {
            var idroom = $('.nav-tabs').children('.active').data('idroom');
            var title = event.title;
            var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
            var end = event.end.format("YYYY-MM-DD[T]HH:mm:SS");
            $.ajax({
                url: 'reservation',
                data: {
                    'title': title,
                    'startdate': start,
                    'enddate': end,
                    'zone': zone,
                    'idroom': idroom
                },
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    if (response.status != 'success') {
                        $('#calendar_room_' + idroom).fullCalendar('removeEvents');
                        getFreshEventsByRoom(idroom);
                        alert(response.msg);
                    }else {
                        event.id = response.reservationId;
                        $('#calendar_room_' + idRoom).fullCalendar('updateEvent', event);
                    }
                },
                error: function (e) {
                    console.log(e.responseText);

                }
            });
            console.log(event);
        },
        eventDrop: function (event, delta, revertFunc) {
            var title = event.title;
            var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
            var end = event.end.format("YYYY-MM-DD[T]HH:mm:SS");
            $.ajax({
                url: 'reservation/' + event.id,
                data: {'title': title, 'startdate': start, 'enddate': end, 'reservationId': event.id},
                type: 'PUT',
                dataType: 'json',
                success: function (response) {
                    if (response.status != 'success') {
                        revertFunc();
                        alert(response.msg);
                    }
                },
                error: function (e) {
                    revertFunc();
                    alert('Error processing your request: ' + e.responseText);
                }
            });
        },
        eventClick: function (event, jsEvent, view) {
            console.log(event.id);
            var title = prompt('Título da reserva:', event.title, {buttons: {Ok: true, Cancel: false}});
            if (title) {
                event.title = title;
                var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
                var end = event.end.format("YYYY-MM-DD[T]HH:mm:SS");
                console.log('type=changetitle&title=' + title + '&eventid=' + event.id);
                $.ajax({
                    url: 'reservation/' + event.id,
                    data: {'title': title, 'startdate': start, 'enddate': end, 'reservationId': event.id},
                    type: 'PUT',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 'success') {
                            $('#calendar_room_' + idRoom).fullCalendar('updateEvent', event);
                        }else{
                            alert(response.msg);
                        }
                    },
                    error: function (e) {
                        alert('Error processing your request: ' + e.responseText);
                    }
                });
            }
        },
        eventResize: function (event, delta, revertFunc) {
            console.log(event);
            var title = event.title;
            var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
            var end = event.end.format("YYYY-MM-DD[T]HH:mm:SS");
            $.ajax({
                url: 'reservation/' + event.id,
                data:{'title': title, 'startdate': start, 'enddate': end, 'reservationId': event.id},
                type: 'PUT',
                dataType: 'json',
                success: function (response) {
                    if (response.status != 'success') {
                        revertFunc();
                        alert(response.msg);
                    }
                },
                error: function (e) {
                    revertFunc();
                    alert('Error processing your request: ' + e.responseText);
                }
            });
        },
        eventDragStop: function (event, jsEvent, ui, view) {
            var idroom = $('.nav-tabs').children('.active').data('idroom');
            if (isElemOverDiv(idroom)) {
                var con = confirm('Tem certeza que deseja excluir esta reserva permanentemente?');
                if (con == true) {
                    $.ajax({
                        url: 'reservation/'+event.id,
                        data: '',
                        type: 'DELETE',
                        dataType: 'json',
                        success: function (response) {
                            console.log(response);
                            if (response.status == 'success') {
                                $('#calendar_room_' + idroom).fullCalendar('removeEvents');
                                getFreshEventsByRoom(idroom);
                            } else {
                                alert(response.msg);
                            }
                        },
                        error: function (e) {
                            alert('Error processing your request: ' + e.responseText);
                        }
                    });
                }
            }
        }
    });
}

function getFreshEventsByRoom(idRoom) {
    $.ajax({
        url: 'reservation/byRoom/' + idRoom,
        type: 'GET',
        data: '',
        async: false,
        success: function (response) {
            $('#calendar_room_' + idRoom).fullCalendar('addEventSource', response);
        }
    });
}


function isElemOverDiv(idRoom) {
    var trashEl = jQuery('#trash_' + idRoom);

    var ofs = trashEl.offset();

    var x1 = ofs.left;
    var x2 = ofs.left + trashEl.outerWidth(true);
    var y1 = ofs.top;
    var y2 = ofs.top + trashEl.outerHeight(true);

    if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
        currentMousePos.y >= y1 && currentMousePos.y <= y2) {
        return true;
    }
    return false;
}

function renderCalendar(idRoom) {
    setTimeout(function () {
            $('#calendar_room_' + idRoom).fullCalendar('render')
        }
        , 900);
}