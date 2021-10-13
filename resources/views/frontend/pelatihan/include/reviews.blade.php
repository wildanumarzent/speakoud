<div class="tab-pane fade" id="search-videos">
    @if ($data['mata']->show_feedback == 1)
        <div class="row">
            <div class="container">
                <div class="card mb-4">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title"> Rating</span>
                    </h6>
                    <div class="card-body shadow">
                        @foreach ($data['numberProgress'] as $i)
                        <div class="progress-course mb-4">
                            <div class="progress">
                                <span class="badge badge-warning"> {{ $i }} </span>
                                <div class="progress-bar" style="width: {{ $data['mata']->rating->count() > 0 ? round(($data['mata']->getRating('per_rating', $i) / $data['mata']->getRating('student_rating')) * 100) : 0 }}%;">
                                    {{ $data['mata']->rating->count() > 0 ? round(($data['mata']->getRating('per_rating', $i) / $data['mata']->getRating('student_rating')) * 100) : 0 }}%
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="text-center text-muted">
                            <h3 class="badge badge-primary" style="font-size: 20px;">
                                {{ $data['mata']->rating->count() > 0 ? round($data['mata']->getRating('review'), 2) : 0 }}
                            </h3><br>
                            {{ $data['mata']->getRating('student_rating') }} Rating Peserta <br class="mb-2">
                            <div class="mb-1"></div>
                             @foreach ($data['numberRating'] as $i)
                                <i class="fa{{ (floor($data['mata']->rating->where('rating', '>', 0)->avg('rating')) >= $i)? 's' : 'r' }} fa-star text-warning" style="font-size: 1.2em;"></i>
                            @endforeach
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    @endif
</div>
