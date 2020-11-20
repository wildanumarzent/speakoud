@extends('layouts.backend.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/fullcalendar/fullcalendar.css') }}">
@endsection

@section('scripts')
    <!-- Dependencies -->
    <script src="{{ asset('assets/tmplts_backend/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/tmplts_backend/vendor/libs/fullcalendar/fullcalendar.js') }}"></script>

    <script src="{{ asset('assets/tmplts_backend/js/ui_fullcalendar.js') }}"></script>
@endsection

@section('content')

    <hr class="container-m-nx border-light mt-0 mb-4">
     <!-- Event modal -->
     <form class="modal modal-top fade" id="fullcalendar-default-view-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add an event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type</label>
                        <select class="custom-select">
                            <option value="" selected>Default</option>
                            <option value="fc-event-success">Success</option>
                            <option value="fc-event-info">Info</option>
                            <option value="fc-event-warning">Warning</option>
                            <option value="fc-event-danger">Danger</option>
                            <option value="fc-event-dark">Dark</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default md-btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary md-btn-flat">Save</button>
                </div>
            </div>
        </div>
    </form>
    <!-- / Event modal -->
    <!-- Detail modal -->
    <form  class="modal modal-top fade" id="fullcalendar-detail-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type</label>
                        <select class="custom-select">
                            <option value="" selected>Default</option>
                            <option value="fc-event-success">Success</option>
                            <option value="fc-event-info">Info</option>
                            <option value="fc-event-warning">Warning</option>
                            <option value="fc-event-danger">Danger</option>
                            <option value="fc-event-dark">Dark</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default md-btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary md-btn-flat">Save</button>
                </div>
            </div>
        </div>
    </form>
    <!-- / Detail modal -->

    <div class="card mb-4">
        <div class="card-body">
            <div id='fullcalendar-default-view'></div>
        </div>
    </div>


<script>
var today = new Date();
var y = today.getFullYear();
var m = today.getMonth();
var d = today.getDate();

var eventList = [
  {
    title: 'All Day Event',
    start: new Date(y, m, d - 12)
  },
  {
    title: 'Long Event',
    start: new Date(y, m, d - 8),
    end: new Date(y, m, d - 5),
    description: 'lorem',
    className: 'fc-event-warning'
  },
  {
    id: 999,
    title: 'Repeating Event',
    start: new Date(y, m, d - 6, 16, 0)
  },
  {
    id: 999,
    title: 'Repeating Event',
    start: new Date(y, m, d + 1, 16, 0),
    className: 'fc-event-success',
  },
  {
    title: 'Conference',
    start: new Date(y, m, d - 4),
    end: new Date(y, m, d - 2),
  },
  {
    title: 'Meeting',
    start: new Date(y, m, d - 3, 10, 30),
    end: new Date(y, m, d - 3, 12, 30),
    className: 'fc-event-danger'
  },
  {
    title: 'Lunch',
    start: new Date(y, m, d  - 3, 12, 0),
    className: 'fc-event-info'
  },
  {
    title: 'Meeting',
    start: new Date(y, m, d - 3, 14, 30),
    className: 'fc-event-dark'
  },
  {
    title: 'Happy Hour',
    start: new Date(y, m, d - 3, 17, 30)
  },
  {
    title: 'Dinner',
    start: new Date(y, m, d - 3, 20, 0)
  },
  {
    title: 'Birthday Party',
    start: new Date(y, m, d - 2, 7, 0)
  },
  {
    title: 'Background event',
    start: new Date(y, m, d + 5),
    end: new Date(y, m, d + 7),
    rendering: 'background'
  },
  {
    title: 'Click for Google',
    url: 'http://google.com/',
    start: new Date(y, m, d + 13)
  }];
</script>

@section('jsbody')
<script type="text/javascript">
    window.livewire.on('eventStore', () => {
        $('#fullcalendar-detail-modal').modal('hide');
    });
</script>
@endsection

@endsection
