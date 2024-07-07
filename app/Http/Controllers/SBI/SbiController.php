<?php

namespace App\Http\Controllers\SBI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SbiController extends Controller
{
    # Dashboard Page
    public function dashboard_page(){
        return view('sbi.dashboard');
    }

    # All Lead Page
    public function all_lead_page(){
        return view('sbi.all_lead');
    }
}
