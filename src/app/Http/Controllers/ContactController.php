<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $contact = $request->only(['category_id','first_name','last_name','gender','email','tel','address','building','detail',]);
        Contact::create($contact);

        return view('thanks');
    }
}