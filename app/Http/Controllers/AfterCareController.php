<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AfterCareController extends Controller
{
    public function index()
    {
        return view('aftercare');
    }
}
