<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {

        
        if (Auth::user()) {
            return View('home');
        }

        return redirect()->route('login');
    }

}
