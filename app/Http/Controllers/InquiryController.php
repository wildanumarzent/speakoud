<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryContactRequest;
use App\Http\Requests\InquiryRequest;
use App\Services\InquiryService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    private $service, $serviceUser;

    public function __construct(
        InquiryService $service,
        UserService $serviceUser
    )
    {
        $this->service = $service;
        $this->serviceUser = $serviceUser;
    }

    public function index(Request $request)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['contact'] = $this->service->getContactList($request);
        $data['number'] = $data['contact']->firstItem();
        $data['contact']->withPath(url()->current().$q);

        return view('backend.inquiry.index', compact('data'), [
            'title' => 'Inquiry',
            'breadcrumbsBackend' => [
                'Inquiry' => ''
            ],
        ]);
    }

    public function read($slug)
    {
        $data['read'] = $this->service->findInquiryBySlug($slug);

        if ($data['read']->publish == 0 || empty($data['read'])) {
            return abort(404);
        }

        if (empty($slug)) {
            return abort(404);
        }

        return view('frontend.inquiry', compact('data'), [
            'title' => $data['read']->name,
            'breadcrumbsFrontend' => [
                'Inquiry' => 'javascript:;',
                $data['read']->name => '',
            ],
        ]);
    }

    public function send(InquiryContactRequest $request, $inquiryId)
    {
        $inquiry = $this->service->findInquiry($inquiryId);

        $message = 'Send message successfully';
        if (!empty('$inquiry->after_body')) {
            $message = strip_tags($inquiry->after_body);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        $this->service->storeContact($request, $inquiryId);

        Mail::to('contact@speakoud.com')
            ->send(new \App\Mail\InquiryContactMail($data));


        // Cookie::queue('inquiry-contact', 'Inquiry Contact', 120);

        return back()->with('success', $message);
    }

    public function edit($id)
    {
        $data['inquiry'] = $this->service->findInquiry($id);

        return view('backend.inquiry.form', compact('data'), [
            'title' => 'Inquiry - Edit',
            'breadcrumbsBackend' => [
                'Inquiry' => route('inquiry.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(InquiryRequest $request, $id)
    {
        $this->service->updateInquiry($request, $id);

        return back()->with('success', 'Inquiry berhasil diedit');
    }

    public function readContact($id)
    {
        $this->service->readContact($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function destroy($id)
    {
        $this->service->deleteContact($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
