<?php

namespace App\Http\Controllers\Course\Bahan;

use App\Http\Controllers\Controller;
use App\Http\Requests\NilaiConferenceRequest;
use App\Services\Course\Bahan\BahanConferenceService;
use App\Services\Course\Bahan\BahanService;
use Illuminate\Http\Request;

class BahanConferenceController extends Controller
{
    private $service, $serviceBahan;

    public function __construct(
        BahanConferenceService $service,
        BahanService $serviceBahan
    )
    {
        $this->service = $service;
        $this->serviceBahan = $serviceBahan;
    }

    public function room($id)
    {
        $data['conference'] = $this->service->findConference($id);

        if (now()->format('Y-m-d') < $data['conference']->tanggal && now() < $data['conference']->start_time) {
            return back()->with('info', 'video conference tidak bisa dimulai, '.
                'dikarenakan belum memasuki tanggal / waktu yang sudah ditentukan');
        }

        if (now()->format('Y-m-d') < $data['conference']->tanggal && now() >= $data['conference']->end_time) {
            return back()->with('info', 'video conference tidak bisa dimulai, '.
                'dikarenakan sudah melebihi waktu yang sudah ditentukan');
        }

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($data['conference']->program->publish == 0 || $data['conference']->bahan->publish == 0) {
                return abort(404);
            }

            if ($data['conference']->status == 0) {
                return back()->with('warning', 'Pengajar belum memulai video conference');
            } elseif ($data['conference']->status == 2) {
                return back()->with('warning', 'Pengajar sudah mengakhiri video conference');
            }

            $restrict = $this->serviceBahan->restrictAccess($data['conference']->bahan_id);
            if (!empty($restrict)) {
                return back()->with('warning', $restrict);
            }

            if ($this->service->checkPesertaJoin($id) == 0) {
                $this->service->trackPesertaJoin($id);
            }
        }

        if (!auth()->user()->hasRole('peserta_internal|peserta_mitra')) {

            if ($data['conference']->status == 2) {
                return back()->with('warning', 'Video conference sudah diakhiri');
            }

            $checkRole = auth()->user()->hasRole('developer|administrator|instruktur_internal');
            if ($checkRole || auth()->user()->hasRole('instruktur_internal|instruktur_mitra') &&
                $data['conference']->materi->instruktur_id == auth()->user()->instruktur->id) {
                $this->service->statusMeet($id, 1);
            } else {
                return abort(403);
            }
        }

        if ($data['conference']->bahan->publish == 0) {
            return abort(404);
        }

        return view('frontend.course.conference.room', compact('data'), [
            'title' => 'Conference - Meet',
            'breadcrumbsBackend' => [
                'Bahan' => route('course.bahan', [
                    'id' => $data['conference']->mata_id,
                    'bahanId' => $data['conference']->bahan_id,
                    'tipe' => 'conference'
                ]),
                'Conference' => ''
            ],
        ]);
    }

    public function peserta(Request $request, $id)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['peserta'] = $this->service->getPesertaList($request, $id);
        $data['number'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$q);
        $data['conference'] = $this->service->findConference($id);

        $this->serviceBahan->checkInstruktur($data['conference']->materi_id);

        return view('frontend.course.conference.peserta', compact('data'), [
            'title' => 'Conference - Peserta',
            'breadcrumbsBackend' => [
                'Bahan' => route('course.bahan', [
                    'id' => $data['conference']->mata_id,
                    'bahanId' => $data['conference']->bahan_id,
                    'tipe' => 'conference'
                ]),
                'Conference' => '',
                'Peserta' => ''
            ],
        ]);
    }

    public function pesertaCheck($id)
    {
        return response()->json([
            'peserta' => $this->service->getPesertaCheckIn($id),
        ]);
    }

    public function startMeet($id)
    {
        $data['conference'] = $this->service->findConference($id);

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($data['conference']->status == 0) {
                return back()->with('warning', 'Instruktur belum memulai video conference');
            } elseif ($data['conference']->status == 2) {
                return back()->with('warning', 'Instruktur sudah mengakhiri video conference');
            }

            if ($this->service->checkPesertaJoin($id) == 0) {
                $this->service->trackPesertaJoin($id);
            }
        }

        if (!auth()->user()->hasRole('peserta_internal|peserta_mitra')) {

            if ($data['conference']->status == 2) {
                return back()->with('warning', 'Video conference sudah diakhiri');
            }

            $checkRole = auth()->user()->hasRole('developer|administrator|internal|mitra');
            if ($checkRole || auth()->user()->hasRole('instruktur_internal|instruktur_mitra') &&
                $data['conference']->creator_id == auth()->user()->id) {
                $this->service->statusMeet($id, 1);
            } else {
                return abort(403);
            }
        }

        if ($data['conference']->bahan->publish == 0) {
            return abort(404);
        }

        return redirect($data['conference']->meeting_link);
    }

    public function leave($id)
    {
        $data['conference'] = $this->service->findConference($id);

        if (!auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            return view('frontend.course.conference.leave', compact('data'));
        } else {
            $this->service->trackPesertaLeave($id);
            return redirect()->route('course.bahan', [
                'id' => $data['conference']->mata_id, 'bahanId' => $data['conference']->bahan_id, 'tipe' => 'conference'
                ])->with('info', 'Anda keluar dari conference');
        }
    }

    public function leaveConfirm($id)
    {
        $conference = $this->service->findConference($id);

        $this->service->statusMeet($id, 2);

        return redirect()->route('course.bahan', [
            'id' => $conference->mata_id, 'bahanId' => $conference->bahan_id, 'tipe' => 'conference'
            ])->with('info', 'Anda keluar dari conference');

    }

    public function checkInVerified(Request $request, $conferenceId, $id)
    {
        $this->service->checkInVerified($id);

        if ($request->tipe == 'detail') {
            return back();
        } else {
            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);
        }
    }

    public function finishConference($id)
    {
        $this->service->statusMeet($id, 2);

        return back()->with('success', 'Video Conference berhasil ditutup');
    }

    public function penilaian(NilaiConferenceRequest $request, $coferenceId, $id)
    {
        $this->service->penilaian($request, $id);

        return back()->with('success', 'berhasil memberikan penilaian untuk webinar');
    }
}
