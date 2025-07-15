<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function dashboard()
    {
        return view('pages.Parent.dashboard');
    }
}
