<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontpageController extends Controller
{
    public function index()
    {
        $result = 42; // Example variable
        return view('index', compact('result'));
    }
}
