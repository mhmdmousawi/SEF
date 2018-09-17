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

        $user = $this->customDuration($user,$start_current_month,$end_current_month);
        return view('dashboard.incomes')->with('user',$user);
    }

    public function weekly()
    {
        $user = Auth::user();
        $start_current_week = Carbon::now()->startOfWeek();
        $end_current_week = Carbon::now()->endOfWeek();

        $user = $this->customDuration($user,$start_current_week,$end_current_week);
        return view('dashboard.incomes')->with('user',$user);
    }

    private function customDuration($user,$start_duration,$end_duration)
    {

        $transactions = $user->profile->transactionsInTimeFrame(
                                            $start_duration,
                                            $end_duration,
                                            "income");
        $transactions =  json_decode($transactions);
        $user->expanded_incomes = $transactions;

        $total_amount = $this->getTotalAmount($transactions);
        $user->total_amount = $total_amount;

        $this->addPercentages(
                    $user->expanded_incomes,
                    $total_amount);
        $daily_average = $this->getDailyAverage(
                                    $start_duration,
                                    $end_duration,
                                    $total_amount);
        $user->daily_average = $daily_average;
        
        return $user;
    }

    private function getDailyAverage($start_date,$end_date,$amount)
    {
        $days_differance = $end_date->diffInDays($start_date)+1;
        $average = round(($amount/$days_differance),2);
        return $average;
    }

    private function addPercentages($transactions,$total_amount)
    {
        foreach($transactions as $transaction){
            $transaction->percentage = round($transaction->amount/$total_amount*100,2);
        }
    }

    private function getTotalAmount($transactions)
    {
        $total_amount = 0 ;
        foreach($transactions as $transaction){
            $total_amount+=$transaction->amount;
        }
        return $total_amount;
    }

}
