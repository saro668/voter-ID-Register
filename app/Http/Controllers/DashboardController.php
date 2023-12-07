<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voter;



class DashboardController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $totalVotersCount  = Voter::getCount();

        $todayVotersCount  = Voter::getTodayRegisterVoteCount();

        return view('dashboard', compact('totalVotersCount', 'todayVotersCount'));
    }
}
