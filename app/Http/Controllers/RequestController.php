<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Request;
use Decimal\Decimal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RequestController extends Controller
{
    public function getAll()
    {
        return $requests = Request::all();
    }
    public function createView(){
        return view('createrequest');
    }
    public function postRequest(\Illuminate\Http\Request $request){

        Log::info($request->all());
        $req = new Request();
        $req->amount_requested = floatval($request['Price']);
        $req->name = $request['Name'];
        $req->equipment = $request['Name'];
        $req->approved = 1;
        $req->description = $request['description'];
        $req->department = Auth::user()->department;
        $req->created_by = Auth::user()->id;
        $req->updated_by = Auth::user()->id;
        $req->type = $request['Type'];
        $req->status = 1;
        $req->save();

        return redirect()->back();
    }

    public function postApprove(\Illuminate\Http\Request $request){

        DB::table('request')
            ->where('id',$request['id'])  // find your user by their email
            ->limit(1)  // optional - to ensure only one record is updated.
            ->update(array('status', $request['status']+1));  // update the record in the DB.
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

    public static function getRequestsByDepartmentAndStatus($department, $status)
    {
        return Request::where('department', $department)->where('status', $status)->get();
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

    public static function getRequestsByUser($user)
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
