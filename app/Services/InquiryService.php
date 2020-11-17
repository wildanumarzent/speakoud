<?php

namespace App\Services;

use App\Models\Inquiry\Inquiry;
use App\Models\Inquiry\InquiryContact;
use Illuminate\Support\Str;

class InquiryService
{
    private $model, $modelContact;

    public function __construct(Inquiry $model, InquiryContact $modelContact)
    {
        $this->model = $model;
        $this->modelContact = $modelContact;
    }

    public function getContactList($request)
    {
        $query = $this->modelContact->query();

        $query->when($request->q, function ($query, $q) {
            $query->where('content->name', 'like', '%'.$q.'%');
        });

        $result = $query->orderBy('submit_time', 'DESC')->paginate(20);

        return $result;
    }

    public function findInquiry(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findInquiryBySlug($slug)
    {
        $query = $this->model->where('slug', $slug);

        $return = $query->first();

        return $return;
    }

    public function findContact(int $id)
    {
        return $this->modelContact->findOrFail($id);
    }

    public function updateInquiry($request, int $id)
    {
        $inquiry = $this->findInquiry($id);
        $inquiry->name = $request->name;
        $inquiry->slug = Str::slug($request->slug);
        $inquiry->body = $request->body ?? null;
        $inquiry->after_body = $request->after_body ?? null;
        $inquiry->publish = (bool)$request->publish;
        $inquiry->show_form = (bool)$request->show_form;
        $inquiry->show_map = (bool)$request->show_map;
        $inquiry->latitude = $request->latitude ?? null;
        $inquiry->longitude = $request->longitude ?? null;
        $inquiry->save();

        return $inquiry;
    }

    public function storeContact($request, int $inquiryId)
    {
        $contact = new InquiryContact;
        $contact->inquiry_id = $inquiryId;
        $contact->ip_address = request()->ip();
        $contact->content = [
            'name' => $request->name ?? null,
            'email' => $request->email ?? null,
            'subject' => $request->subject ?? null,
            'message' => $request->message ?? null,
        ];
        $contact->submit_time = now();
        $contact->save();

        return $contact;
    }

    public function deleteContact(int $id)
    {
        $contact = $this->findContact($id);
        $contact->delete();

        return $contact;
    }

    public function readContact(int $id)
    {
        $contact = $this->findContact($id);
        $contact->status = 1;
        $contact->save();

        return $contact;
    }
}
