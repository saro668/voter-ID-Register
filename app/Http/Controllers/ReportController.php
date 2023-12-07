<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voter;
use App\Models\State;
use App\Models\District;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\VotersExport;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Voter::select('voters.*', 'states.state_name', 'districts.district_name')
                ->join('states', 'voters.state_id', '=', 'states.id')
                ->join('districts', 'voters.district_id', '=', 'districts.id')
                ->orderBy('voters.created_at', 'DESC');

        if ($request->filled('district')) {
            $query->where('voters.district_id', 'like', '%' . $request->input('district') . '%');
        }

        if ($request->filled('state')) {
            $query->where('voters.state_id', 'like', '%' . $request->input('state') . '%');
        }

        $voters = $query->paginate(5);

        $states = State::where('status', 'Active')->get();
        $districts = [];
        if ($request->filled('district')) {
            $districts = District::where('status', 'Active')->where('state_id', $request->district)->get();
        }



        return view('report.index', compact('voters', 'states', 'districts'));
    }

    public function export(Request $request)
    {

        return Excel::download(new VotersExport($request->input('district'), $request->input('state')), 'voters.xlsx');
    }

}
