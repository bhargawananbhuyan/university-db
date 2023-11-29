<?php

namespace App\Http\Controllers;

use App\Models\ContactQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicAccessController extends Controller
{
    public function home()
    {
        return view("index");
    }

    public function contact()
    {
        return view("contact");
    }

    public function contact_query(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'query_content' => 'required|string'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        ContactQuery::create([
            'name' => $request->name,
            'email' => $request->email,
            'query' => $request->query_content,
        ]);

        return redirect()->back()->with('success', 'Thanks for reaching out. We\'ll contact you soon.');

    }
}
