
@include('sweetalert::alert')




    <hr class="container-m-nx border-light mt-1 mb-4">

    <div class="card mb-4">
        <div class="card-body">
            <div id="kalender-diklat"></div>
        </div>
    </div>



    <script>
   $(function () {
  var today = new Date();
  var y = today.getFullYear();
  var m = today.getMonth();
  var d = today.getDate();
var eventList = [];


  // Default view
  // color classes: [ fc-event-success | fc-event-info | fc-event-warning | fc-event-danger | fc-event-dark ]
  var defaultCalendar = new Calendar($('#kalender-diklat')[0], {

    plugins: [
      calendarPlugins.bootstrap,
      calendarPlugins.dayGrid,
      calendarPlugins.timeGrid,
      calendarPlugins.interaction
    ],
    dir: $('html').attr('dir') || 'ltr',

    // Bootstrap styling
    themeSystem: 'bootstrap',
    bootstrapFontAwesome: {
      close: ' ion ion-md-close',
      prev: ' ion ion-ios-arrow-back scaleX--1-rtl',
      next: ' ion ion-ios-arrow-forward scaleX--1-rtl',
      prevYear: ' ion ion-ios-arrow-dropleft-circle scaleX--1-rtl',
      nextYear: ' ion ion-ios-arrow-dropright-circle scaleX--1-rtl'
    },

    header: {
      left: 'title',
    //   center: 'dayGridMonth,timeGridWeek,timeGridDay',
      right: 'prev,next today'
    },
    timeZone: 'Asia/Jakarta',
    defaultDate: today,
    navLinks: true, // can click day/week names to navigate views
    selectable: true,
    weekNumbers: true, // Show week numbers
    nowIndicator: true, // Show "now" indicator
    firstDay: 1, // Set "Monday" as start of a week
    businessHours: {
      dow: [1, 2, 3, 4, 5], // Monday - Friday
      start: '9:00',
      end: '18:00',
    },
    // @role ('developer|administrator|internal')
    editable: true,
    // @endrole
    eventLimit: true, // allow "more" link when too many events
    events: "{{route('agenda.list')}}",

    views: {
      dayGrid: {
        eventLimit: 5
      }
    },

       eventClick: function(calEvent) {
        $("#delete").attr("disabled", false);
        $('#kalender-diklat-modal')
        .on('shown.bs.modal', function() {


            document.getElementById("spatieCalendar").style.display = "block";

            $('.modal-title').text('Event'+' - '+calEvent.event.title);
            $('#description').text(calEvent.event.extendedProps.description);
            $('#judul').val(calEvent.event.title);
            $('#link').val(calEvent.event.extendedProps.link);
            $('#ulink').text(calEvent.event.extendedProps.link);
            $('#eventID').val(calEvent.event.id);
            $('#startTime').val(moment(calEvent.event.start).format('HH:mm'));
            $('#endTime').val(moment(calEvent.event.end).format('HH:mm'));
            $('.start').val(moment(calEvent.event.start).format('YYYY-MM-DD'));
            $('.end').val(moment(calEvent.event.end).format('YYYY-MM-DD'));
            var className = document.getElementById("className").value  = calEvent.event.classNames;

            if(calEvent.event.extendedProps.link != null){
                document.getElementById('ulink').href =  calEvent.event.extendedProps.link;
            }
            var google = String("http://www.google.com/calendar/event?action=TEMPLATE&dates="+moment(calEvent.event.start)
            .format('YYYYMMDDTHHMMSS')+"%2F"+moment(calEvent.event.end)
            .format('YYYYMMDDTHHMMSS')+"&text="+calEvent.event.title+"&location=&details="
            +calEvent.event.extendedProps.description
            +calEvent.event.extendedProps.link);
            document.getElementById('googleLink').href = google;





        })
        .on('hidden.bs.modal', function() {
          $(this)
            .off('shown.bs.modal hidden.bs.modal submit')
            .find('input[type="text"], select').val('');
            $('#description').text('');
          defaultCalendar.unselect();
          document.getElementById('googleLink').href = '#';
        })
        .modal('show');
    },

    select: function (selectionData) {

      $('#kalender-diklat-modal')
        .on('shown.bs.modal', function() {
            document.getElementById("spatieCalendar").style.display = "none";

            $('.start').val(selectionData.startStr);
            $('.end').val(selectionData.endStr);
          $(this).find('input[name="title"]').trigger('focus');
        })
        .on('hidden.bs.modal', function() {
          $(this)
            .off('shown.bs.modal hidden.bs.modal submit')
            .find('input[type="text"], select').val('');
          defaultCalendar.unselect();
        })
        .modal('show');
    },

    eventDrop: function (event) {
                        var start = (moment(event.event.start).format('YYYY-MM-DD'));
                        var end = (moment(event.event.end).format('YYYY-MM-DD'));
                        let _token   = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: 'event/update',
                            type: "POST",
                            data:{
                            id:event.event.id,
                            title:event.event.title,
                            start:start,
                            end:end,
                            _token: _token
                            },
                            success: function (response) {
                                // window.location.reload(1);
                            },
                            error: function(req, err){ console.log('my message' + err); }
                        });
                    },


  });


  defaultCalendar.render();


});

    </script>
    @include('includes.tiny-mce-with-fileman')
