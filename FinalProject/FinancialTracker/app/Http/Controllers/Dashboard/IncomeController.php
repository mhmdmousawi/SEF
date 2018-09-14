<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateInterval;

class IncomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $user->incomes = $this->transactionsInTimeFrame("income");

        return view('dashboard.incomes')->with('user',$user);
    }


    public function transactionsInTimeFrame($type)
    {

        //custom duration
        $s_date = '2018-9-1';
        $e_date = '2018-9-20';

        $transactions = Auth::user()->profile->transactionsWithType($type);

        // $start_date = strtotime($s_date);
        // $end_date = strtotime($e_date);

        $ss_date = new DateTime($s_date);
        $se_date = new DateTime($e_date);
         
        $filtered_transactions = [];
        foreach ($transactions as $transaction) {

            $ts_date = new DateTime($transaction->start_date);
            $te_date = new DateTime($transaction->end_date);


            if($transaction->repeat->type == 'fixed'){
                
                if($ts_date > $ss_date && $ts_date < $se_date ){
                    // $filtered_transactions[$i++] = $transaction;
                    $transaction->category;
                    $transaction->category->logo;
                    $transaction->repeat;
                    array_push($filtered_transactions, $transaction);
                }
                
            }else {
            
                $recurrent_date = $ts_date;

                while($recurrent_date > $ss_date && $recurrent_date <= $se_date){
                    
                    $transaction->start_date = $recurrent_date->format('Y-m-d');
                    // $filtered_transactions[$i++] = clone $transaction;
                    $transaction->category;
                    $transaction->category->logo;
                    $transaction->repeat;

                    array_push($filtered_transactions, clone $transaction);
                
                    if($transaction->repeat->type == 'daily'){
                        $recurrent_date = $recurrent_date->add(new DateInterval('P1D'));
                    }else if($transaction->repeat->type = 'weekly'){
                        $recurrent_date = $recurrent_date->add(new DateInterval('P1W'));
                    }else if($transaction->repeat->type = 'monthly'){
                        $recurrent_date = $recurrent_date->add(new DateInterval('P1M'));
                    }
                }
            }
        }
        return json_encode($filtered_transactions);
    }
}
