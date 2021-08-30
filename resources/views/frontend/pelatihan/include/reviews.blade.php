<div class="tab-pane fade" id="search-videos">
    @if ($data['mata']->show_feedback == 1)
        <div class="row">
            <div class="container">
                <div class="card mb-4">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title"> Rating</span>
                    </h6>
                    <div class="card-body">
                        @foreach ($data['numberProgress'] as $i)
                        <div class="progress-course mb-4">
                            <div class="progress">
                                <span class="badge badge-warning mr-3"> {{ $i }} </span>
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
                            {{ $data['mata']->getRating('student_rating') }} Rating Peserta
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="small text-center">
                            @role ('peserta_internal|peserta_mitra')
                            <select id="rating" name="rating" class="mb-2">
                                <option value="" ></option>
                                @for ($i = 1; $i < 6; $i++)
                                <option value="{{ $i }}" {{ $data['mata']->ratingByUser()->count() > 0 ? ($data['mata']->ratingByUser->rating == $i ? 'selected' : '') : 0 }}>1</option>
                                @endfor
                            </select>
                            @else
                            @if ($data['mata']->rating->count() > 0)
                            @foreach ($data['numberRating'] as $i)
                                <i class="fa{{ (floor($data['mata']->rating->where('rating', '>', 0)->avg('rating')) >= $i)? 's' : 'r' }} fa-star text-warning" style="font-size: 1.8em;"></i>
                            @endforeach
                            @else
                            @foreach ($data['numberRating'] as $i)
                                <i class="far fa-star text-warning" style="font-size: 1.8em;"></i>
                            @endforeach
                            @endif
                            @endrole
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
