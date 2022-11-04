<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Request;
use Decimal\Decimal;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\Input;

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

        $reqID =  $request['requestID'];
        if (isset($_POST['reject_button'])) {
            Request::where('id',$reqID)
                ->update([
                    'approved' => 0]);
        } else if (isset($_POST['approve_button'])) {
            Request::where('id',$reqID)
                ->update([
                    'status' => Auth::user()->role +1,
                    'updated_by' => Auth::user()->id]);

            $status = Request::where('id',  $reqID)
                ->first()->status;

            if($status ==4)
            {
                Request::where('id',  $reqID)
                    ->update([
                        'approved' => 2]);
            }
        }

        return redirect()->back();
    }

    public function get($id)
    {
        return Request::find($id)->first();
    }

    public function getStatus($id)
    {
        return Request::find($id)->first();
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

    public static function getRequestsAtHODLevel($department, $status)
    {
        return Request::where('department', $department)->where('status','>=', 2)->get();
    }


    public function escalateRequest(Request $request)
    {
        $currentStatus = Auth::user()->role;
        switch ($currentStatus) {
            case 'employee'://0
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
        return Request::where('created_by', $user->id)->get();
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
