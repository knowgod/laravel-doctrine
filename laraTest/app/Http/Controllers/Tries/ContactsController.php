<?php

namespace App\Http\Controllers\Tries;

use App\Contact;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContactsController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('tries.contacts.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        return view('tries.contacts.show', compact('contact'));
    }
}
