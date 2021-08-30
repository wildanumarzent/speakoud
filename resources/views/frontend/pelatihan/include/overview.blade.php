
<div class="tab-pane fade show active" id="search-pages">
<div class="card">
    <div class="row no-gutters row-bordered row-border-light">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="ui-bordered">
                        <div class="p-4">
                            {!! $data['mata']->program->keterangan !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-4 pt-0">
            <div class="container">
                <table class="table-responsive mt-3">
                    <tr>
                        <th><h6 style="padding-right: 79px"><i class="fas fa-question" style="color: orange"></i> Quizzes</h6></th>
                        <th><h6><strong>{{count($data['mata']->quiz)}}</strong></h6></th>   
                    </tr>
                </table>
                <hr style="color: orange">
                <table class="table-responsive mt-3">
                    <tr>
                        <th><h6 style="padding-right: 63px"><i class="far fa-file-alt" style="color: orange"></i> Certificate</h6></th>
                        <th><h6><strong>No</strong></h6></th>     
                    </tr>
                </table>
                <hr style="color: orange">
                <table class="table-responsive mt-3">
                    <tr>
                        <th><h6 style="padding-right: 41px"><i class="fas fa-check-circle" style="color: orange"></i> Assessments</h6></th>
                        <th><h6><strong>yes</strong></strong></h6></th>     
                    </tr>
                </table>
                <hr style="color: orange">
                <table class="table-responsive mt-3">
                    <tr>
                        <th><h6 style="padding-right: 66px"><i class="fas fa-users" style="color: orange"></i> Students</h6></th>
                        <th><h6><strong>{{$data['mata']->peserta->count()}}</strong></h6></th>       
                    </tr>
                </table>
                <hr style="color: orange">
                    <table class="table-responsive mt-3">
                    <tr>
                            <th><h6 style="padding-right: 70px"><i class="far fa-clock" style="color: orange"></i> Duration</h6></th>
                        <th><h6><strong>{{$data['duration']->days}} days</strong></h6></th>        
                    </tr>
                </table>
                <hr style="color: orange">
            </div>
        </div>
    </div>
</div>
</div>
