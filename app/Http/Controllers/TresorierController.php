<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TresorierController extends Controller
{
    public function TresorierDashboard(){
        return view('tresorier.dashboard');
    }
}
