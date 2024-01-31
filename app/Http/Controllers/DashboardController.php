<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Redirect;
// use Illuminate\Support\Arr;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;
// use Laravel\Fortify\Contracts\CreatesNewUsers;
// use Laravel\Jetstream\Jetstream;
// use App\Models\Currency;
// use App\Models\Service_rate;
// use DB;

class DashboardController extends Controller
{
    public function index()
    {
       // $data = Currency::all();
        return view('pages.dashboard');
    }
}
