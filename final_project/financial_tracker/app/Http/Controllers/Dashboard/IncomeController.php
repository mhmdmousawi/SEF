<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IncomeController extends Controller
{
    public function monthly()
    {
        $user = Auth::user();
        $start_current_month = Carbon::now()->startOfMonth();
        $end_current_month = Carbon::now()->endOfMonth();

        $user->expanded_incomes = json_decode(
            $user->profile->transactionsInTimeFrame($start_current_month,$end_current_month,"income"));
        
        return view('dashboard.incomes')->with('user',$user);
    }

    public function weekly()
    {
        $user = Auth::user();
        $start_current_week = Carbon::now()->startOfWeek();
        $end_current_week = Carbon::now()->endOfWeek();

        $user->expanded_incomes = json_decode(
            $user->profile->transactionsInTimeFrame($start_current_week,$end_current_week,"income"));
        
        return view('dashboard.incomes')->with('user',$user);
    }

}
