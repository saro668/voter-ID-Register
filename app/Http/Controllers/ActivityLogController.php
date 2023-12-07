<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use DataTables;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) 
        {
        
            $data = ActivityLog::select('activity_logs.*', 'users.name', 'users.email')
                ->join('users', 'users.id', '=', 'activity_logs.user_id')
                ->orderBy('activity_logs.created_at', 'desc')
                ->get();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }
        
        return view('activitylog.index');
    }
}
