<div class="tab-pane fade show active" id="search-pages">
<div class="row justify-content-between">
        <div class="col-lg-7">
            <!-- <div class="card mb-4">
                <div class="card-body">
                    <div class="ui-bordered">
                        <div class="p-4">
                            {{-- {{dd($data['mata'])}} --}}
                            {!! $data['mata']->content !!}
                        </div>
                    </div>
                </div>
            </div> -->
            <article>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolorem at voluptate nihil accusamus, molestiae laboriosam minima fugiat iste atque magni error possimus eligendi deleniti tempora nam eveniet quos, maxime ad!</p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </article>
        </div>
        <div class="col-lg-4">
            <div class="box-information">
                <ul class="list-information">
                    <li class="item-information">
                        <div class="title-information">
                            <i class="las la-question"></i>
                            <span>Quizzes</span>
                        </div>
                        <div class="data-information">
                            <span>{{count($data['mata']->quiz)}}</span>
                        </div>
                    </li>
                    <li class="item-information">
                        <div class="title-information">
                            <i class="las la-award"></i>
                            <span>Certificate</span>
                        </div>
                        <div class="data-information">
                            @if ($data['mata']->is_sertifikat == 1)
                                <span>Yes</span>
                            @else
                                <span>No</span>
                            @endif
                        </div>
                    </li>
                    <li class="item-information">
                        <div class="title-information">
                            <i class="las la-check-circle"></i>
                            <span>Assessments</span>
                        </div>
                        <div class="data-information">
                            @if ($data['mata']->is_penilaian == 1)
                                <span>Yes</span>
                            @else
                                <span>No</span>
                            @endif
                        </div>
                    </li>
                    <li class="item-information">
                        <div class="title-information">
                            <i class="las la-users"></i>
                            <span>Students</span>
                        </div>
                        <div class="data-information">
                            <span>{{$data['mata']->peserta->count()}}</span>
                        </div>
                    </li>
                    <li class="item-information">
                        <div class="title-information">
                            <i class="las la-stopwatch"></i>
                            <span>Duration</span>
                        </div>
                        <div class="data-information">
                            <span>{{$data['duration']->days}} days</span>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- <div class="container">
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
                        <th>
                            @if ($data['mata']->is_sertifikat == 1)
                                <h6><strong>Yes</strong></h6>
                            @else
                                <h6><strong>No</strong></h6>
                            @endif
                        </th>
                    </tr>
                </table>
                <hr style="color: orange">
                <table class="table-responsive mt-3">
                    <tr>
                        <th><h6 style="padding-right: 41px"><i class="fas fa-check-circle" style="color: orange"></i> Assessments</h6></th>
                        <th>
                             @if ($data['mata']->is_penilaian == 1)
                                <h6><strong>Yes</strong></h6>
                            @else
                                <h6><strong>No</strong></h6>
                            @endif
                        </th>
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
            </div> -->
        </div>
    </div>
</div>
