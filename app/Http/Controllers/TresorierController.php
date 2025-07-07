<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TresorierController extends Controller
{
    public function tresorierDashboard(){
        return view('tresorier.dashboard');
    }
    public function userDemandes(){
        return view('tresorier.demandes');
        
    }
    public function OP(){
        return view('tresorier.op');

    }
    public function OV(){
        return view('tresorier.ov');

    }
    public function createOP(){
        return view('tresorier.create-OP');

    }
    public function createOV(){
        return view('tresorier.create-OV');

    }
    
}
