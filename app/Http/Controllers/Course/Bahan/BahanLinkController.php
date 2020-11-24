<?php

namespace App\Http\Controllers\Course\Bahan;

use App\Http\Controllers\Controller;
use App\Services\Course\Bahan\BahanLinkService;
use Illuminate\Http\Request;

class BahanLinkController extends Controller
{
    private $service;

    public function __construct(BahanLinkService $service)
    {
        $this->service = $service;
    }

    public function room($id)
    {
        $data['link'] = $this->service->findLink($id);

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($data['link']->program->publish == 0 || $data['link']->bahan->publish == 0) {
                return abort(404);
            }

            if ($this->service->checkPesertaJoin($id) == 0) {
                $this->service->trackPesertaJoin($id);
            }
        }

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($data['link']->status == 0) {
                return back()->with('warning', 'Instruktur belum memulai video conference');
            } elseif ($data['link']->status == 2) {
                return back()->with('warning', 'Instruktur sudah mengakhiri video conference');
            }
        }

        if (!auth()->user()->hasRole('peserta_internal|peserta_mitra')) {

            if ($data['link']->status == 2) {
                return back()->with('warning', 'Video conference sudah diakhiri');
            }

            $checkRole = auth()->user()->hasRole('developer|administrator|internal|mitra');
            if ($checkRole || auth()->user()->hasRole('instruktur_internal|instruktur_mitra') &&
                $data['link']->creator_id == auth()->user()->id) {
                $this->service->statusMeet($id, 1);
            } else {
                return abort(403);
            }
        }

        if ($data['link']->bahan->publish == 0) {
            return abort(404);
        }

        return view('frontend.course.link.room', compact('data'), [
            'title' => 'Conference - Meet',
            'breadcrumbsBackend' => [
                'Bahan' => route('course.bahan', [
                    'id' => $data['link']->mata_id,
                    'bahanId' => $data['link']->bahan_id,
                    'tipe' => 'link'
                ]),
                'Meet' => ''
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
        $data['link'] = $this->service->findLink($id);

        return view('frontend.course.link.peserta', compact('data'), [
            'title' => 'Link - Peserta',
            'breadcrumbsBackend' => [
                'Bahan' => route('course.bahan', [
                    'id' => $data['link']->mata_id,
                    'bahanId' => $data['link']->bahan_id,
                    'tipe' => 'link'
                ]),
                'Link' => '',
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
        $data['link'] = $this->service->findLink($id);

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($data['link']->status == 0) {
                return back()->with('warning', 'Instruktur belum memulai video conference');
            } elseif ($data['link']->status == 2) {
                return back()->with('warning', 'Instruktur sudah mengakhiri video conference');
            }

            if ($this->service->checkPesertaJoin($id) == 0) {
                $this->service->trackPesertaJoin($id);
            }
        }

        if (!auth()->user()->hasRole('peserta_internal|peserta_mitra')) {

            if ($data['link']->status == 2) {
                return back()->with('warning', 'Video conference sudah diakhiri');
            }

            $checkRole = auth()->user()->hasRole('developer|administrator|internal|mitra');
            if ($checkRole || auth()->user()->hasRole('instruktur_internal|instruktur_mitra') &&
                $data['link']->creator_id == auth()->user()->id) {
                $this->service->statusMeet($id, 1);
            } else {
                return abort(403);
            }
        }

        if ($data['link']->bahan->publish == 0) {
            return abort(404);
        }

        return redirect($data['link']->meeting_link);
    }

    public function leave($id)
    {
        $data['link'] = $this->service->findLink($id);

        if (!auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            return view('frontend.course.link.leave', compact('data'));
        } else {
            return redirect()->route('course.bahan', [
                'id' => $data['link']->mata_id, 'bahanId' => $data['link']->bahan_id, 'tipe' => 'link'
                ])->with('info', 'Anda keluar dari conference');
        }
    }

    public function leaveConfirm($id)
    {
        $link = $this->service->findLink($id);

        $this->service->statusMeet($id, 2);

        return redirect()->route('course.bahan', [
            'id' => $link->mata_id, 'bahanId' => $link->bahan_id, 'tipe' => 'link'
            ])->with('info', 'Anda keluar dari conference');

    }

    public function checkInVerified(Request $request, $linkId, $id)
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
}
