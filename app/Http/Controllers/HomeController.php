<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('auth.login-student-parent');
    }

    public function landingPage()
    {
        return view('landingPage');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function about()
    {
        return view('auth.aboutus');
    }

}
