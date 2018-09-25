<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Session;

class IncomeController extends Controller
{
    public function index()
    {
        // Session::forget('time_filter');
        if(!Session::get('time_filter')){
            $now = date("Y-m-d");
            $this->setTimeFilter($now);
            // $this->setTimeFilter("2018-10-1");
        }

        $time_filter = Session::get('time_filter');
        $type_filter = $time_filter['type_filter'];
        $date_filter = $time_filter['date_filter'];

        if($type_filter == 'weekly'){
            return $this->weekly($date_filter)->with('dashboard_type','incomes');
        }else if($type_filter == 'monthly'){
            return $this->monthly($date_filter)->with('dashboard_type','incomes');
        }else if( $type_filter == 'yearly'){
            return $this->yearly($date_filter)->with('dashboard_type','incomes');
            // return "Page under construction";
        }
    }
    private function setTimeFilter($date)
    {
        $type_filter = "monthly";
        $date_filter = $date;

        $time_filter = [
            'type_filter' => $type_filter,
            'date_filter' => $date_filter
        ];
        Session::put('time_filter', $time_filter);
    }

    public function weekly($date)
    {
        $user = Auth::user();
        $carbon_date = Carbon::createFromFormat('Y-m-d', $date);
        $start_current_week = clone $carbon_date->startOfWeek();
        $end_current_week = clone $carbon_date->endOfWeek();
        $user = $this->customDuration($user,$start_current_week,$end_current_week);
        return view('dashboard.incomes')->with('user',$user);
    }

    public function monthly($date)
    {
        $user = Auth::user();
        $carbon_date = Carbon::createFromFormat('Y-m-d', $date);
        $start_current_month = clone $carbon_date->startOfMonth();
        $end_current_month = clone $carbon_date->endOfMonth();
        $user = $this->customDuration($user,$start_current_month,$end_current_month);
        return view('dashboard.incomes')->with('user',$user);
    }

    public function yearly($date)
    {
        $user = Auth::user();
        $carbon_date = Carbon::createFromFormat('Y-m-d', $date);
        $start_current_year = clone $carbon_date->startOfYear();
        $end_current_year = clone $carbon_date->endOfYear();
        $user = $this->customDuration($user,$start_current_year,$end_current_year);
        return view('dashboard.incomes')->with('user',$user);   
    }

    private function customDuration($user,$start_duration,$end_duration)
    {

        $transactions = $user->profile->transactionsInTimeFrame(
                                            $start_duration,
                                            $end_duration,
                                            "income");
        $transactions =  json_decode($transactions);

        $user->stat_categories_info = $this->getCategoriesInfo($user,$transactions);
        

        $user->expanded_incomes = $transactions;

        $total_amount = $this->getTotalAmount($user,$transactions);
        $user->total_amount = $total_amount;

        $this->addPercentages(
                    $user,
                    $user->expanded_incomes,
                    $total_amount);
        $daily_average = $this->getDailyAverage(
                                    $start_duration,
                                    $end_duration,
                                    $total_amount);
        $user->daily_average = $daily_average;

        return $user;
    }

    private function getCategoriesInfo($user,$transactions)
    {
        $grouped_categories = array();
        $category_title = array();
        $category_amounts = array();
        $category_info = array();

        foreach ($transactions as $transaction) {
            $grouped_categories[$transaction->category->title][] = $transaction->amount;
        }

        foreach($grouped_categories as $key => $category){

            $cat_total_amount = 0;
            foreach($grouped_categories[$key] as $key1 => $amount){
                $cat_total_amount += $amount;
            }
            array_push($category_title,$key);
            array_push($category_amounts,$cat_total_amount);
        }
        array_push($category_info,$category_title);
        array_push($category_info,$category_amounts);

        return $category_info;
    }

    private function getDailyAverage($start_date,$end_date,$amount)
    {
        $days_differance = $end_date->diffInDays($start_date)+1;
        $average = round(($amount/$days_differance),2);
        return $average;
    }

    private function addPercentages($user,$transactions,$total_amount)
    {
        $default_currency_rate = $user->profile->defaultCurrency->amount_per_dollar;

        foreach($transactions as $transaction){
            //need edit
            $amount_in_default_curr = ($transaction->amount*$default_currency_rate)
                                        /($transaction->currency->amount_per_dollar);
            
            $transaction->percentage = round($amount_in_default_curr/$total_amount*100,2);
        }
    }

    private function getTotalAmount($user ,$transactions)
    {
        $default_currency_rate = $user->profile->defaultCurrency->amount_per_dollar;
        $total_amount = 0 ;
        foreach($transactions as $transaction){
            $amount_in_default_curr = ($transaction->amount*$default_currency_rate)
                                        /($transaction->currency->amount_per_dollar);
            $total_amount+=$amount_in_default_curr;
        }
        return $total_amount;
    }

}
