<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateInterval;
use Carbon\Carbon;

class IncomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // $user->expanded_incomes = $this->transactionsInTimeFrame("income",'2018-9-1','2018-9-13');
        $user->expanded_incomes = json_decode(Auth::user()->profile->transactionsInTimeFrame("income",'2018-9-1','2018-9-13'));
        
        return view('dashboard.incomes')->with('user',$user);
    }

    public function monthly()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $start_current_month = Carbon::now()->startOfMonth();
        $end_current_month = Carbon::now()->endOfMonth();

        $user->expanded_incomes = json_decode(
            $user->profile->transactionsInTimeFrame("income",$start_current_month,$end_current_month));
        
        return view('dashboard.incomes')->with('user',$user);
    }

    public function weekly()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $start_current_week = Carbon::now()->startOfWeek();
        $end_current_week = Carbon::now()->endOfWeek();

        $user->expanded_incomes = json_decode(
            $user->profile->transactionsInTimeFrame("income",$start_current_week,$end_current_week));
        
        return view('dashboard.incomes')->with('user',$user);
    }

}
