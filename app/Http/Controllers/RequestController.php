<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function getAll()
    {
        return $requests = Request::all();
    }

    public function get($id)
    {
        return $request = Request::find($id)->first();
    }

    public function create(Request $request)
    {
        $request->save();
    }

    public function delete(int $id)
    {
        $request = Request::find($id);
        $request->delete();
    }

    public function getRequestsByDepartmentAndStatus($department, $status)
    {
        return $requests = Request::where('department', $department)->where('status', $status)->get();
    }

    public function escalateRequest(Request $request)
    {
        $currentStatus = Auth::user()->role;
        switch ($currentStatus) {
            case 'employee':
                $request->status = '1';
                break;
            case 'manager':
                $request->status = '2';
                break;
            case 'director':
                $request->status = '3';
                break;
        }
        $request->save();
    }

    public function getRequestsByDepartment($department)
    {
        return $requests = Request::where('department', $department)->get();
    }

    public function getRequestsByStatus($status)
    {
        return $requests = Request::where('status', $status)->get();
    }

    public function cancelRequest(Request $request)
    {
        $request->status = "C";
        $request->save();
    }

    public function getRequestsByUser($user)
    {
        return $requests = Request::where('created_by', $user->id)->get();
    }

    public function getRequestsByUserAndStatus($user, $status)
    {
        return $requests = Request::where('created_by', $user->id)->where('status', $status)->get();
    }

    public function approveRequest(Request $request)
    {
        $request->status = "A";
        $request->save();
    }

    public function denyRequest(Request $request)
    {
        $request->status = "R";
        $request->save();
    }

    public function getAllCurrentUserRequests()
    {
        return $requests = Request::where('created_by', Auth::user()->id)->get();
    }


}
