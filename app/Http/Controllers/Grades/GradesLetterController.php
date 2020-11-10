<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradesLetterRequest;
use App\Services\Grades\LetterService;
use Illuminate\Http\Request;

class GradesLetterController extends Controller
{
    private $service;

    public function __construct(LetterService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['letter'] = $this->service->getLetterList($request);
        $data['number'] = $data['letter']->firstItem();
        $data['letter']->withPath(url()->current().$q);

        return view('backend.grades_management.letter.index', compact('data'), [
            'title' => 'Grades - Letter',
            'breadcrumbsBackend' => [
                'Grades' => '',
                'Letter' => ''
            ],
        ]);
    }

    public function create()
    {
        return view('backend.grades_management.letter.form', [
            'title' => 'Letter - Tambah',
            'breadcrumbsBackend' => [
                'Grades' => '',
                'Letter' => route('grades.letter'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(GradesLetterRequest $request)
    {
        $this->service->storeLetter($request);

        return redirect()->route('grades.letter')
            ->with('success', 'Grades letter berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['letter'] = $this->service->findLetter($id);

        return view('backend.grades_management.letter.form', compact('data'), [
            'title' => 'Letter - Edit',
            'breadcrumbsBackend' => [
                'Grades' => '',
                'Letter' => route('grades.letter'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(GradesLetterRequest $request, $id)
    {
        $this->service->updateLetter($request, $id);

        return redirect()->route('grades.letter')
            ->with('success', 'Grades letter berhasil diedit');
    }

    public function destroy($id)
    {
        $this->service->deleteLetter($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
