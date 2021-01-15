<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Badge\BadgeService;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use App\Services\Course\Bahan\BahanForumService;
use App\Http\Requests\BadgeRequest;
use App\Models\Badge\Badge;
use App\Services\Course\Bahan\BahanService;
use App\Models\Course\Bahan\BahanForumTopik;
class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(BadgeService $badge,MataService $mata,MateriService $materi,BahanService $bahan,BahanForumService $forum, BahanForumTopik $topik)
     {
        $this->badge = $badge;
        $this->mata = $mata;
        $this->bahan = $bahan;
        $this->materi = $materi;
        $this->forum = $forum;
        $this->topik = $topik;
     }
    public function index()
    {
        // $data['badge'] = $this->badge->list();
        return view('backend.badge.index', compact('data'), [
            'title' => 'Badge',
            'breadcrumbsBackend' => [
                'Badge' => ''
            ],
        ]);
    }

    public function list($mataID)
    {
        $data['badge'] = $this->badge->list($mataID);
        $data['mataID'] = $mataID;
        $data['mata'] = $this->mata->findMata($mataID)->judul;
        $mata = $this->mata->findMata($mataID)->first();
        return view('backend.badge.index', compact('data'), [
            'title' => 'Badge',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $mata['program_id']]),
                'Badge' => '',
            ],
        ]);
    }
    public function myBadge()
    {
        $data['badge'] = $this->badge->list();
        $data['myBadge'] = $this->badge->getBadgePeserta(auth()->user()->peserta->id);
        $data['count']['badge'] = $this->badge->countBadge(auth()->user()->peserta->id);
        $data['mata'] = $this->mata->getMataPeserta(auth()->user()->peserta->id);
        return view('backend.badge.peserta', compact('data'), [
            'title' => 'Badge',
            'breadcrumbsBackend' => [
                'Badge' => '',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create($mataID , Request $request)
    {
        $data['tipe'] = $request['type'];
        switch ($data['tipe']) {
            case 'program':
                $data['minimumLabel'] = 'Persentase Minimum';
                $data['data'] = null;
                break;
            case 'mata':
                $data['minimumLabel'] = 'Persentase Minimum';
                $data['data'] = $this->materi->getAllMateri($mataID);
                break;
            case 'materi':
                $data['minimumLabel'] = 'Persentase Minimum';
                $mata = $this->materi->getAllMateri($mataID);
                $mataList = $mata->pluck('id');
                $data['data'] = $this->bahan->getBahanForMata($mataList);
                break;
            case 'forum':
                $data['minimumLabel'] = 'Post Minimum';
                $data['data'] = $this->forum->getForumForMata($mataID);
                $data['tipeUtama'] = '0';
                break;
            case 'topic':
                $data['minimumLabel'] = 'Reply Minimum';
                $data['data'] = $this->forum->getTopikForMata($mataID);
                $data['tipeUtama'] = '0';
                break;

        }
        $data['mata'] = $this->mata->findMata($mataID)->first();
        $data['mataID'] = $mataID;
        if($data['tipe'] != 'program'){
            if($data['data']->count() < 1){
                return redirect()->back()->with('warning','Data '.$data['tipe'].' Kosong, Untuk Membuat Badge Setidaknya perlu 1 Data '.$data['tipe']);
            }
        }
        return view('backend.badge.form', compact('data'), [
            'title' => 'Badge',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['mata']['program_id']]),
                'Badge' => route('badge.list',['mataID' => $mataID]),
                'Tambah' => ''
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BadgeRequest $request)
    {
        $data['badge'] = $request->validated();
        $this->badge->store($data['badge']);
        return redirect()->route('badge.list',['mataID' => $data['badge']['mata_id']])->with('success' , 'Badge Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Badge $badge, Request $request)
    {
        switch ($request['type']) {
            case 'program':
                $data['minimumLabel'] = 'Persentase Minimum';
                $data['data'] =null;
                break;
            case 'mata':
                $data['minimumLabel'] = 'Persentase Minimum';
                $data['data'] = $this->materi->getAllMateri($badge['mata_id']);
                break;
            case 'materi':
                $data['minimumLabel'] = 'Persentase Minimum';
                $mata = $this->materi->getAllMateri($badge['mata_id']);
                $mataList = $mata->pluck('id');
                $data['data'] = $this->bahan->getBahanForMata($mataList);
                break;
                case 'forum':
                    $data['minimumLabel'] = 'Post Minimum';
                    $data['data'] = $this->forum->getForumForMata($badge['mata_id']);
                    $data['tipeUtama'] = '0';
                    break;
                case 'topic':
                    $data['minimumLabel'] = 'Reply Minimum';
                    $data['data'] = $this->forum->getTopikForMata($badge['mata_id']);
                    $data['tipeUtama'] = '0';
                    break;

        }


        if($request['type'] != 'program'){
            if($data['data']->count() < 1){
                return redirect()->back()->with('warning','Data '.$data['tipe'].' Kosong, Untuk Membuat Badge Setidaknya perlu 1 Data '.$data['tipe']);
            }
        }
        $data['tipe'] = $request['type'];
        $data['badge'] = $this->badge->get($badge['id']);
        $data['mataID'] = $badge['mata_id'];
        $data['mata'] = $this->mata->findMata($badge['mata_id'])->first();
        return view('backend.badge.form', compact('data'), [
            'title' => 'Badge',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                 'Program' => route('mata.index', ['id' => $data['mata']['program_id']]),
                'Badge' => route('badge.list',['mataID' => $badge['mata_id']]),
                'Tambah' => ''
            ],
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BadgeRequest $request, $id)
    {
        $data = $this->badge->update($id,$request);

        return redirect()->route('badge.list',['mataID' => $data['mata_id']])->with('success' , 'Badge Berhasil Disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->badge->delete($id);
        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
