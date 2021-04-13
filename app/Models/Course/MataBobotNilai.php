<?php

namespace App\Models\Course;

use App\Models\Course\Bahan\ActivityCompletion;
use App\Models\Course\Bahan\BahanConferencePeserta;
use App\Models\Course\Bahan\BahanForumTopik;
use App\Models\Course\Bahan\BahanForumTopikDiskusi;
use App\Models\Course\Bahan\BahanPelatihan;
use App\Models\Course\Bahan\BahanQuiz;
use App\Models\Course\Bahan\BahanQuizUserTracker;
use Illuminate\Database\Eloquent\Model;

class MataBobotNilai extends Model
{
    protected $table = 'mata_bobot_nilai';
    protected $guarded = [];

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }

    public function bobotVidConf($mataId, $pesertaId)
    {
        $mata = MataPelatihan::find($mataId);

        $conference = BahanPelatihan::where('mata_id', $mataId)
            ->where('segmenable_type', 'App\Models\Course\Bahan\BahanConference')->count();
        $myConference = BahanConferencePeserta::whereHas('conference', function ($query) use ($mataId) {
                $query->where('mata_id', $mataId);
            })->where('user_id', $pesertaId)->where('check_in_verified', 1)->count();

        if ($myConference > 0) {
            $total = round($myConference / $conference * $mata->bobot->join_vidconf);
            $percen = $total;
        } else {
            $percen = '0';
        }

        return $percen;
    }

    public function bobotActivity($mataId, $pesertaId)
    {
        $mata = MataPelatihan::find($mataId);

        $completion = BahanPelatihan::where('mata_id', $mataId)
            ->where('completion_type', '>', 0)->whereNotNull('segmenable_id')->count();
        $myCompletion = ActivityCompletion::where('mata_id', $mataId)
            ->where('user_id', $pesertaId)->whereNotNull('track_end')->count();

        if ($myCompletion > 0) {
            $total = round($myCompletion / $completion * $mata->bobot->activity_completion);
            $percen = $total;
        } else {
            $percen = '0';
        }

        return $percen;
    }

    public function bobotForum($mataId, $pesertaId)
    {
        $mata = MataPelatihan::find($mataId);

        $topik = BahanForumTopik::where('mata_id', $mataId)->where('creator_id', $pesertaId)
            ->count();
        $reply = BahanForumTopikDiskusi::where('mata_id', $mataId)->where('user_id', $pesertaId)
            ->count();
        $forum = ($topik+$reply);

        if ($forum > 0) {
            $total = round($forum / 5 * $mata->bobot->forum_diskusi);
            if ($total > $mata->bobot->forum_diskusi) {
                $percen = $mata->bobot->forum_diskusi;
            } else {
                $percen = $total;
            }

        } else {
            $percen = '0';
        }

        return $percen;
    }

    public function bobotWebinar($mataId, $pesertaId)
    {
        $mata = MataPelatihan::find($mataId);

        $webinar = BahanPelatihan::where('mata_id', $mataId)
            ->where('segmenable_type', 'App\Models\Course\Bahan\BahanConference')->count();
        $myWebinar = BahanConferencePeserta::whereHas('conference', function ($query) use ($mataId) {
                $query->where('mata_id', $mataId);
            })->where('user_id', $pesertaId)->where('check_in_verified', 1)
                ->where('konfirmasi', 1)->whereNotNull('nilai')->count();

        if ($myWebinar > 0) {
            $total = round($myWebinar / $webinar * $mata->bobot->webinar);
            $percen = $total;
        } else {
            $percen = '0';
        }

        return $percen;
    }

    public function bobotProgress($mataId, $pesertaId)
    {
        $mata = MataPelatihan::find($mataId);

        $progress = BahanQuiz::where('mata_id', $mataId)
            ->where('kategori', 3)->count();
        $myProgress = BahanQuizUserTracker::whereHas('quiz', function ($query) use ($mataId) {
                $query->where('mata_id', $mataId)->where('kategori', 3);
            })->where('status', 2)->where('user_id', $pesertaId)->count();

        if ($myProgress > 0) {
            $total = round($myProgress / $progress * $mata->bobot->progress_test);
            $percen = $total;
        } else {
            $percen = '0';
        }

        return $percen;
    }

    public function bobotQuiz($mataId, $pesertaId)
    {
        $mata = MataPelatihan::find($mataId);

        $quiz = BahanQuiz::where('mata_id', $mataId)
            ->whereIn('kategori', [1,4])->count();
        $myQuiz = BahanQuizUserTracker::whereHas('quiz', function ($query) use ($mataId) {
                $query->where('mata_id', $mataId)->whereIn('kategori', [1,4]);
            })->where('status', 2)->where('user_id', $pesertaId)->count();

        if ($myQuiz > 0) {
            $total = round($myQuiz / $quiz * $mata->bobot->quiz);
            $percen = $total;
        } else {
            $percen = '0';
        }

        return $percen;
    }

    public function bobotPost($mataId, $pesertaId)
    {
        $mata = MataPelatihan::find($mataId);

        $post = BahanQuiz::where('mata_id', $mataId)
            ->where('kategori', 2)->count();
        $myPost = BahanQuizUserTracker::whereHas('quiz', function ($query) use ($mataId) {
                $query->where('mata_id', $mataId)->where('kategori', 2);
            })->where('status', 2)->where('user_id', $pesertaId)->count();

        if ($myPost > 0) {
            $total = round($myPost / $post * $mata->bobot->post_test);
            $percen = $total;
        } else {
            $percen = '0';
        }

        return $percen;
    }

    public function bototTugasMandiri($mataId, $pesertaId)
    {
        $percen = '0';

        return $percen;
    }

    public function totalBobot($mataId, $pesertaId)
    {
        $vindConf = $this->bobotVidConf($mataId, $pesertaId);
        $activity = $this->bobotActivity($mataId, $pesertaId);
        $forum = $this->bobotForum($mataId, $pesertaId);
        $webinar = $this->bobotWebinar($mataId, $pesertaId);
        $progress = $this->bobotProgress($mataId, $pesertaId);
        $quiz = $this->bobotQuiz($mataId, $pesertaId);
        $post = $this->bobotPost($mataId, $pesertaId);
        $tugasMandiri = $this->bototTugasMandiri($mataId, $pesertaId);

        $total = ($vindConf+$activity+$forum+$webinar+$progress+$quiz+$post);

        return $total;
    }
}
