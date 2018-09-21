<?php

namespace App\CustomClasses;

use Illuminate\Support\Facades\Auth;
use App\Transaction;
use Carbon\Carbon;
use DateTime;
use DateInterval;

class Calculator 
{
    public function weekOverallCalculation($week_start_date)
    {
        $carbon_date = Carbon::createFromFormat('Y-m-d',$week_start_date);
        $start_current_week = clone $carbon_date->startOfWeek();
        $end_current_week = clone $carbon_date->endOfWeek();
        $overall_amount = $this->overallCalculationWithin($start_current_week,$end_current_week);

        return $overall_amount;
    }

    public function monthOverallCalculation($month_start_date)
    {
        $carbon_date = Carbon::createFromFormat('Y-m-d',$month_start_date);
        $start_current_month = clone $carbon_date->startOfMonth();
        $end_current_month = clone $carbon_date->endOfMonth();
        $overall_amount = $this->overallCalculationWithin($start_current_month,$end_current_month);

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

        $transactions_expense = $profile->transactionsWithTypeAndRepeat($date,"expense");
        $transactions_expense = json_decode($transactions_expense);
        $total_amount_expense = $this->getTotalAmount($transactions_expense);

        $transactions_saving = $profile->transactionsWithTypeAndRepeat($date,"saving");
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
}