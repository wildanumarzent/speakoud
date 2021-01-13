<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanConference;
use App\Models\Course\Bahan\BahanConferencePeserta;
use Illuminate\Database\Eloquent\Builder;

class BahanConferenceService
{
    private $model, $modelPeserta;

    public function __construct(
        BahanConference $model,
        BahanConferencePeserta $modelPeserta
    )
    {
        $this->model = $model;
        $this->modelPeserta = $modelPeserta;
    }

    public function getPesertaList($request, int $id)
    {
        $query = $this->modelPeserta->query();

        $query->where('conference_id', $id);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($queryA) use ($q) {
                $queryA->whereHas('user', function (Builder $queryB) use ($q) {
                    $queryB->where('name', 'ilike', '%'.$q.'%')
                        ->orWhereHas('peserta', function (Builder $queryC) use ($q) {
                            $queryC->orWhere('nip', 'ilike', '%'.$q.'%');
                        });
                });
            });
        });

        $result = $query->paginate(20);

        return $result;
    }

    public function getPesertaCheckIn(int $id)
    {
        $query = $this->modelPeserta->join('users', 'conference_user_tracker.user_id',
             '=', 'users.id')->select('conference_user_tracker.id as id',
                'conference_user_tracker.check_in_verified', 'conference_user_tracker.join',
                'conference_user_tracker.check_in', 'conference_user_tracker.check_in_verified',
                'users.name');

        $query->where('conference_id', $id);
        $result = $query->orderBy('join', 'ASC')->get();

        return $result;
    }

    public function latestConference()
    {
        $query = $this->model->query();

        $query->whereHas('bahan', function ($query) {
            $query->publish();
        });
        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            $query->whereHas('materi', function ($query) {
                $query->where('instruktur_id', auth()->user()->instruktur->id);
            });
        }

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            $query->whereHas('mata', function ($query) {
                $query->where('publish_start', '<=', now())
                        ->where('publish_end', '>=', now());
                $query->whereHas('program', function ($query) {
                    $query->publish();
                    if (auth()->user()->hasRole('peserta_mitra')) {
                        $query->where('tipe', 1)->where('mitra_id', auth()->user()->peserta->mitra_id);
                    } else {
                        $query->where('tipe', 0);
                    }
                });
                $query->publish();
                $query->whereHas('peserta', function ($queryB) {
                    $queryB->where('peserta_id', auth()->user()->peserta->id);
                });
            });
        }

        $result = $query->orderBy('created_at', 'DESC')->orderBy('status', 'ASC')
            ->limit(5)->get();

        return $result;
    }

    public function findConference(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeConference($request, $materi, $bahan)
    {
        if ($request->tipe == 0) {
            $client = new \GuzzleHttp\Client();
            $url = config('addon.api.conference.end_point');

            $parameter = [
                'title' => $request->judul,
                'description' => $request->keterangan,
                'schedule' => [
                    'startDate' => $request->tanggal,
                    'start' => $request->start_time,
                    'end' => $request->end_time,
                ],
            ];

            $response = $client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'X-BPPT-Secret' => 'u7x!A%C*F-JaNdRgUkXp2s5v8y/B?E(G+KbPeShVmYq3t6w9z$C&F)J@McQfTjWn',
                ],
                'body' => json_encode($parameter),
            ]);

            $getBody = $response->getBody();
        } else {
            $getBody = null;
        }

        $conference = new BahanConference;
        $conference->program_id = $materi->program_id;
        $conference->mata_id = $materi->mata_id;
        $conference->materi_id = $materi->id;
        $conference->bahan_id = $bahan->id;
        $conference->creator_id = auth()->user()->id;
        $conference->tipe = (bool)$request->tipe;
        $conference->tanggal = $request->tanggal;
        $conference->start_time = $request->tanggal.' '.$request->start_time;
        $conference->end_time = $request->tanggal.' '.$request->end_time;
        $conference->meeting_link = ($request->tipe == 0) ? $this->generateRandomString() :
            $request->meeting_link;
        $conference->api = $getBody;
        $conference->save();

        return $conference;

    }

    public function updateConferece($request, $bahan)
    {
        if ($request->tipe == 0) {
            $client = new \GuzzleHttp\Client();
            $url = config('addon.api.conference.end_point');

            $parameter = [
                'title' => $request->judul,
                'description' => $request->keterangan,
                'schedule' => [
                    'startDate' => $request->tanggal,
                    'start' => $request->start_time,
                    'end' => $request->end_time,
                ],
            ];

            $response = $client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'X-BPPT-Secret' => 'u7x!A%C*F-JaNdRgUkXp2s5v8y/B?E(G+KbPeShVmYq3t6w9z$C&F)J@McQfTjWn',
                ],
                'body' => json_encode($parameter),
            ]);

            $getBody = $response->getBody();
        } else {
            $getBody = null;
        }

        $conference = $bahan->conference;
        $conference->tipe = (bool)$request->tipe;
        $conference->tanggal = $request->tanggal;
        $conference->start_time = $request->tanggal.' '.$request->start_time;
        $conference->end_time = $request->tanggal.' '.$request->end_time;
        $conference->meeting_link = ($request->tipe == 0) ? $this->generateRandomString() :
            $request->meeting_link;
        $conference->api = $getBody;
        $conference->save();

        return $conference;
    }

    public function generateRandomString($length = 16)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function statusMeet(int $id, $status)
    {
        $link = $this->findConference($id);
        $link->status = $status;
        $link->save();

        return $link;
    }

    public function checkPesertaJoin(int $id)
    {
        $query = $this->modelPeserta->query();

        $query->where('conference_id', $id)->where('user_id', auth()->user()->id);

        $result = $query->count();

        return $result;
    }

    public function trackPesertaJoin(int $id)
    {
        $peserta = new BahanConferencePeserta();
        $peserta->conference_id = $id;
        $peserta->user_id = auth()->user()->id;
        $peserta->join = now();
        $peserta->save();

        return $peserta;
    }

    public function trackPesertaLeave(int $id)
    {
        $peserta = $this->modelPeserta->where('conference_id', $id)
            ->where('user_id', auth()->user()->id)->first();
        $peserta->leave = now();
        $peserta->save();

        return $peserta;
    }

    public function checkInVerified(int $id)
    {
        $peserta = $this->modelPeserta->findOrFail($id);
        $peserta->check_in = now();
        $peserta->check_in_verified = 1;
        $peserta->save();

        return $peserta;
    }

    public function penilaian($request, int $id)
    {
        $peserta = $this->modelPeserta->findOrFail($id);
        $peserta->nilai = $request->nilai;
        $peserta->catatan = $request->catatan ?? null;
        $peserta->konfirmasi = (bool)$request->konfirmasi;
        $peserta->save();

        return $peserta;
    }
}
