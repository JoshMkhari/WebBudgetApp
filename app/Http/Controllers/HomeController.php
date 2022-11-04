<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
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
                $requests = RequestController::getRequestsByDepartmentAndStatus(Auth::user()->department,Auth::user()->role);
                return view('linemanagerhome')->with('requests',$requests);
            case 2:
                $requests = RequestController::getRequestsAtHODLevel(Auth::user()->department,Auth::user()->role);
                return view('hodhome')->with('requests',$requests);
            case 3:
                $requests = RequestController::getRequestsAtHODLevel(Auth::user()->department,Auth::user()->role);
                return view('financehome')->with('requests',$requests);
            default:
                return view('auth.login');

        }
    }
}
