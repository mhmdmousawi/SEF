<?php

namespace App\CustomClasses;

use Illuminate\Support\Facades\Auth;
use App\Transaction;
use App\Currency;
use Carbon\Carbon;
use DateTime;
use DateInterval;

class Calculator 
{
    public function defaultAmount($amount,$currency_id)
    {
        $user = Auth::user();
        $currency = Currency::find($currency_id);
        $default_currency_rate = $user->profile->defaultCurrency->amount_per_dollar;
        $amount_in_default_curr = ($amount*$default_currency_rate)
                                        /($currency->amount_per_dollar);
        return $amount_in_default_curr;
    }

    public function weekOverallCalculation($week_start_date)
    {
        $carbon_date = Carbon::createFromFormat('Y-m-d',$week_start_date);
        $start_current_week = clone $carbon_date->startOfWeek();
        $end_current_week = clone $carbon_date->endOfWeek();
        $week_overall = $this->overallCalculationWithin($start_current_week,$end_current_week);
        $balance_until_week_start = $this->overallCalculationUntil($start_current_week->subDays(1));
        $overall_amount = $balance_until_week_start + $week_overall;

        return $overall_amount;
    }

    public function monthOverallCalculation($month_start_date)
    {
        $carbon_date = Carbon::createFromFormat('Y-m-d',$month_start_date);
        $start_current_month = clone $carbon_date->startOfMonth();
        $end_current_month = clone $carbon_date->endOfMonth();
        $month_overall = $this->overallCalculationWithin($start_current_month,$end_current_month);
        $balance_until_month_start = $this->overallCalculationUntil($start_current_month->subDays(1));
        $overall_amount = $balance_until_month_start + $month_overall;

        return $overall_amount;
        
    }

    public function overallCalculation()
    {
        $user = Auth::user();
        $profile = $user->profile;

        $transactions_income = $profile->transactionsWithTypeAndRepeat("income");
        $transactions_income = json_decode($transactions_income);
        $total_amount_income = $this->getTotalAmount($transactions_income);

        $transactions_expense = $profile->transactionsWithTypeAndRepeat("expense");
        $transactions_expense = json_decode($transactions_expense);
        $total_amount_expense = $this->getTotalAmount($transactions_expense);

        $transactions_saving = $profile->transactionsWithTypeAndRepeat("saving");
        $transactions_saving = json_decode($transactions_saving);
        $total_amount_saving = $this->getTotalAmount($transactions_saving);

        $overall_amount = $total_amount_income - ($total_amount_expense + $total_amount_saving);
        return $overall_amount;
    }

    public function overallCalculationUntil($date)
    {
        $user = Auth::user();
        $profile = $user->profile;

        $transactions_income = $profile->transactionsWithTypeAndRepeatUntil($date,"income");
        $transactions_income = json_decode($transactions_income);
        $total_amount_income = $this->getTotalAmount($transactions_income);

        $transactions_expense = $profile->transactionsWithTypeAndRepeatUntil($date,"expense");
        $transactions_expense = json_decode($transactions_expense);
        $total_amount_expense = $this->getTotalAmount($transactions_expense);

        $transactions_saving = $profile->transactionsWithTypeAndRepeatUntil($date,"saving");
        $transactions_saving = json_decode($transactions_saving);
        $total_amount_saving = $this->getTotalAmount($transactions_saving);

        $overall_amount = $total_amount_income - ($total_amount_expense + $total_amount_saving);
        return $overall_amount;
    }

    public function overallCalculationWithin($start_date,$end_date)
    {
        $transactions_income = $this->getTransactionsInTimeFrame(
                                            "income",
                                            $start_date,
                                            $end_date);
        $total_amount_income = $this->getTotalAmount($transactions_income);

        $transactions_expense = $this->getTransactionsInTimeFrame(
                                            "expense",
                                            $start_date,
                                            $end_date);
        $total_amount_expense = $this->getTotalAmount($transactions_expense);

        $transactions_saving = $this->getTransactionsInTimeFrame(
                                            "saving",
                                            $start_date,
                                            $end_date);
        $total_amount_saving = $this->getTotalAmount($transactions_saving);

        $overall_amount = $total_amount_income - ($total_amount_expense + $total_amount_saving);
        return $overall_amount;
    }

    private function getTransactionsInTimeFrame($type,$start_date,$end_date)
    {
        $user = Auth::user();
        $transactions = $user->profile->transactionsInTimeFrame(
                                                $start_date,
                                                $end_date,
                                                $type);
        $transactions =  json_decode($transactions);
        return $transactions;
    }

    private function getTotalAmount($transactions)
    {
        $user = Auth::user();
        $default_currency_rate = $user->profile->defaultCurrency->amount_per_dollar;
        $total_amount = 0 ;
        foreach($transactions as $transaction){
            $amount_in_default_curr = ($transaction->amount*$default_currency_rate)
                                        /($transaction->currency->amount_per_dollar);
            $total_amount+=$amount_in_default_curr;
        }
        return $total_amount;
    }

    public function dueDate($goal_amount,$amount,$start_date,$repeat_id)
    {
        $reccurent_date = Carbon::createFromFormat('Y-m-d',$start_date);
        $added_amouunt = $amount;

        while($added_amouunt < $goal_amount){

            $reccurent_date = $reccurent_date->addDayes(7);
            $added_amouunt += $amount;
            if($repeat_id == 3){

            }else if($repeat_id == 4){

            }
        }
        

    }
}