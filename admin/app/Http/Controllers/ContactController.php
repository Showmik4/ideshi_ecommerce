<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $contact = Contact::all();
        return datatables()->of($contact)
            ->addColumn('created_at', function (Contact $contact){
                return date('Y-m-d', strtotime($contact->created_at));
            })
            ->setRowAttr([
                'align'=>'center',
            ])
            ->make(true);
    }

    public function delete(Request $request): JsonResponse
    {
        $contact = Contact::query()->where('contactId', $request->contactId)->first();
        If (!empty($contact)) {
            $contact->delete();
        }
        return response()->json();
    }
}
