<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shortener;

class LinksController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function show($hash)
    {
        $url = Shortener::getUrlByHash($hash);

        return redirect(url($url));
    }

    public function store(Request $request)
    {
        $hash = Shortener::make($request->input('shorten'));

        return ['link' => 'http://voidte.am/' . $hash];
    }
}
