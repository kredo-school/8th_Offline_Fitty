<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NaomiController extends Controller
{
    //
    public function landing(){
        return view('landing');
    }

    public function about(){
        return view('about');
    }

    public function team(){
        return view('team');
    }

    public function contact(){
        return view('contact');
    }
}
