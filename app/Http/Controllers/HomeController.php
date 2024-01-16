<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }
    public function urla()
    {
        return view('home.urla');
    }
    public function loginpage()
    {
        return view('home.login');
    }
    public function signuppage()
    {
        return view('home.signup');
    }

    public function otpcheck()
    {
        return view('home.otpcheck');
    }
    public function setpage()
    {
        return view('home.setpage');
    }

}
