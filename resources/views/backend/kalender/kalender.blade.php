@section('content')
@include('sweetalert::alert')

<div class="modal modal-top fade" id="kalender-diklat-modal">
    @role ('developer|administrator|internal')
    <form id="eventSubmit" method="post" action="{{route('event.store')}}">
        @csrf
        <input type="hidden" name="id" id="eventID">
        <input type="hidden" class="form-control start" name="start" placeholder="Start Date">
        <input type="hidden" class="form-control end" name="end" placeholder="End Date">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Event</h5>
                <div id="spatieCalendar">
                <a href="#" id="googleLink" target="_blank" title="klik untuk menambahkan ke google calendar" class="btn btn-sm icon-btn btn-outline-danger ">
                    <span class="fab fa-google"></span>
                </a>
                </div>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button> --}}
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Judul Event</label>
                    <input id="judul" type="text" class="form-control" name="title" placeholder="Judul Event" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea cols="30" rows="10" id="description" class="form-control  @error('description') is-invalid @enderror" name="description" placeholder="masukan description..."></textarea>
                </div>
                <div class="form-group">
                      <label class="form-label">Jam Mulai</label>
                        <div class="input-group">
                            <input required type="text" class="time-picker form-control @error('start_time') is-invalid @enderror" name="start_time" id="startTime"
                               placeholder="masukan jam mulai...">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="las la-clock"></i></span>
                            </div>
                            @include('components.field-error', ['field' => 'start_time'])
                        </div>
                </div>
                <div class="form-group">

                      <label class="form-label">Jam Selesai</label>


                        <div class="input-group">
                            <input required type="text" class="time-picker form-control @error('end_time') is-invalid @enderror" name="end_time" id="endTime"
                                placeholder="masukan jam selesai...">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="las la-clock"></i></span>
                            </div>
                            @include('components.field-error', ['field' => 'end_time'])
                        </div>

                </div>
                <div class="form-group">
                    <label class="form-label">Tipe Warna</label>
                    <select class="custom-select" name="className" id="className">
                        <option value="" selected>Biru</option>
                        <option value="fc-event-success">Hijau</option>
                        <option value="fc-event-info">Hijau Muda</option>
                        <option value="fc-event-warning">Kuning</option>
                        <option value="fc-event-danger">Merah</option>
                        <option value="fc-event-dark">Hitam</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Url Link</label>
                    <a id="ulink" target="_blank" href="#"></a>
                    <input id="link" type="text" class="form-control" name="link" placeholder="Url Link">
                </div>
                {{-- <div class="form-group">
                    <label class="form-label">Sepanjang Hari</label>
                    <input type="checkbox" class="" name="allDay" id="allDay" value="1">Yes
                </div> --}}
            </div>
            <div class="modal-footer">
                <button type="submit" id="delete" name="action" value="destroy" class="btn btn-danger md-btn-flat" disabled>Hapus</button>
                <button type="button" class="btn btn-default md-btn-flat" data-dismiss="modal">Tutup</button>
                <button type="submit" id="save" name="action" value="submit" class="btn btn-primary md-btn-flat">Simpan</button>

            </div>
        </div>
    </div>

</form>
@else
<div class="modal-dialog modal-lg">
    <input type="hidden" id="className">
    <input type="hidden" id="allDay">

    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"></h5>
            <div id="spatieCalendar">
                <a href="" id="googleLink" target="_blank" title="klik untuk menambahkan ke google calendar" class="btn btn-sm icon-btn btn-outline-danger ">
                    <span class="fab fa-google"></span>
                </a>
                </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <p id="description"></p>
            </div>
            <div class="form-group">
                <label class="form-label">Url Link</label>
                <a id="ulink" target="_blank" href="#">Here</a>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default md-btn-flat" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
@endrole
</div>


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
    @role ('developer|administrator|internal')
    editable: true,
    @endrole
    eventLimit: true, // allow "more" link when too many events
    events: "{{route('event.list')}}",

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
