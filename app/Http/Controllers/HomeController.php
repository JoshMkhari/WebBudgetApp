<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Switch_;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        switch (Auth::user()->role){
            case 0:
                $requests = RequestController::getRequestsByUser(Auth::user());
                return view('home')->with('requests',$requests);
            case 1:
                return view('linemanagerhome');
            case 2:
                return view('hodhome');
            case 3:
                return view('financehome');
            default:
                return view('auth.login');

        }
    }
}
