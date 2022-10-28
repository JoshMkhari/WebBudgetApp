<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function logout(){
        Session::flush();

        Auth::logout();

        return redirect('login');
    }
    public function index()
    {
        $user = Auth::user();
        return view('user.index', compact('user'));
    }
    public function getAllUnverifiedUsers()
    {
        $Role = Auth::user()->role;
        return $users = User::select()->where('verified_at', null)->where('verified_by',null)->where('role','<',$Role)->get();
    }
    public function verifyUser(int $id):bool
    {
        $user = User::find($id);
        if ($user->role<Auth::user()->role){
            $user->verified_by = Auth::user()->id;
            $user->verified_at = now();
            $user->save();
            return true;
        }else{
            return false;
        }
    }
    public function demoteUser(int $id):bool
    {
        $user = User::find($id);
        if ($user->role<Auth::user()->role){
            $user->role = $user->role-1;
            $user->save();
            return true;
        }else{
            return false;
        }
    }
    public function promoteUser(int $id):bool
    {
        $user = User::find($id);
        if ($user->role<Auth::user()->role){
            $user->role = $user->role+1;
            $user->save();
            return true;
        }else{
            return false;
        }
    }
    public function deleteUser(int $id):bool
    {
        $user = User::find($id);
        if ($user->role<Auth::user()->role){
            $user->delete();
            return true;
        }else{
            return false;
        }
    }
    public function getAllUsersByDepartment()
    {
        $Role = Auth::user()->role;
        $Department = Auth::user()->department;
        return $users = User::select()->where('role','<',$Role)->where('Department',$Department)->get();
    }



}
