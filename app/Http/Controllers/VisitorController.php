<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function about(){
        $about = 'lol';
        return view('general.about',compact('about'));
    }
}
