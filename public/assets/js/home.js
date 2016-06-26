/**
 * Created by fernando on 24/06/16.
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function() {

    var zone = "03:00";  //timezone

    $.ajax({
        url: 'reservation',
        type: 'GET',
        data: '',
        async: false,
        success: function(s){
            json_events = s;
        }
    });


    var currentMousePos = {
        x: -1,
        y: -1
    };
    jQuery(document).on("mousemove", function (event) {
        currentMousePos.x = event.pageX;
        currentMousePos.y = event.pageY;
    });

    /* initialize the external events
     -----------------------------------------------------------------*/

    $('#external-events .fc-event').each(function() {

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


    /* initialize the calendar
     -----------------------------------------------------------------*/

    $('#calendar').fullCalendar({
        events: json_events.reservation,
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
        snapDuration : '01:00:00',
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
        allDaySlot : false,
        eventReceive: function(event){
            var title = event.title;
            var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
            $.ajax({
                url: 'reservation',
                data: {'title': title, 'startdate': start, 'zone': zone},
                type: 'POST',
                dataType: 'json',
                success: function(response){
                    event.id = response.eventid;
                    $('#calendar').fullCalendar('updateEvent',event);
                },
                error: function(e){
                    console.log(e.responseText);

                }
            });
            $('#calendar').fullCalendar('updateEvent',event);
            console.log(event);
        },
        eventDrop: function(event, delta, revertFunc) {
            var title = event.title;
            var start = event.start.format();
            var end = (event.end == null) ? start : event.end.format();
            $.ajax({
                url: 'process.php',
                data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id,
                type: 'POST',
                dataType: 'json',
                success: function(response){
                    if(response.status != 'success')
                        revertFunc();
                },
                error: function(e){
                    revertFunc();
                    alert('Error processing your request: '+e.responseText);
                }
            });
        },
        eventClick: function(event, jsEvent, view) {
            console.log(event.id);
            var title = prompt('Event Title:', event.title, { buttons: { Ok: true, Cancel: false} });
            if (title){
                event.title = title;
                console.log('type=changetitle&title='+title+'&eventid='+event.id);
                $.ajax({
                    url: 'process.php',
                    data: 'type=changetitle&title='+title+'&eventid='+event.id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 'success')
                            $('#calendar').fullCalendar('updateEvent',event);
                    },
                    error: function(e){
                        alert('Error processing your request: '+e.responseText);
                    }
                });
            }
        },
        eventResize: function(event, delta, revertFunc) {
            console.log(event);
            var title = event.title;
            var end = event.end.format();
            var start = event.start.format();
            $.ajax({
                url: 'process.php',
                data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id,
                type: 'POST',
                dataType: 'json',
                success: function(response){
                    if(response.status != 'success')
                        revertFunc();
                },
                error: function(e){
                    revertFunc();
                    alert('Error processing your request: '+e.responseText);
                }
            });
        },
        eventDragStop: function (event, jsEvent, ui, view) {
            if (isElemOverDiv()) {
                var con = confirm('Are you sure to delete this event permanently?');
                if(con == true) {
                    $.ajax({
                        url: 'process.php',
                        data: 'type=remove&eventid='+event.id,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response){
                            console.log(response);
                            if(response.status == 'success'){
                                $('#calendar').fullCalendar('removeEvents');
                                getFreshEvents();
                            }
                        },
                        error: function(e){
                            alert('Error processing your request: '+e.responseText);
                        }
                    });
                }
            }
        }
    });

    function getFreshEvents(){
        $.ajax({
            url: 'process.php',
            type: 'POST', // Send post data
            data: 'type=fetch',
            async: false,
            success: function(s){
                freshevents = s;
            }
        });
        $('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
    }


    function isElemOverDiv() {
        var trashEl = jQuery('#trash');

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

});