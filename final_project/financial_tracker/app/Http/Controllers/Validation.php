<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\CustomClasses\Calculator;
use App\Transaction;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use Validator;
use Session;


class Validation extends Controller
{
    private $calculator;

    public function validateSmartSaving(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'goal_amount' => 'required|numeric',
            'title' => 'required|max:255',
            'description' => 'max:255',
            'currency_id' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'priority' => 'required|in:time,money',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 401);
        }

        $calculate = new Calculator;
        $this->calculator = $calculate;
        $valid_response = false;
        $priority = $request->priority;
        $goal_amount = $calculate->defaultAmount($request->goal_amount,$request->currency_id);
        $start_date = $request->start_date;
        $end_date = $request->end_date; 
        
        
        $isValid_goal = $this->goalValid($goal_amount,$end_date);

        if($priority == "money"){

            $weekly_valid_info = $this->goalAmountFrequentlyValid($goal_amount,$start_date,$end_date,3);
            $monthly_valid_info  = $this->goalAmountFrequentlyValid($goal_amount,$start_date,$end_date,4);
            
            if($weekly_valid_info['valid']){
                $repeat_id = 3;
                $amount = $weekly_valid_info['amount'];
                $isValid_fequently = true;
            }
            if($monthly_valid_info['valid']){
                $repeat_id = 4;
                $amount = $monthly_valid_info['amount'];
                $isValid_fequently = true;
            }
            
            if($isValid_goal && $isValid_fequently){

                $valid_response = true;

                $transaction = new Transaction;
                $transaction->profile_id = Auth::user()->profile->id;
                $transaction->amount = $calculate->exchangeFromDefault($amount,$request->currency_id); 
                $transaction->type= "saving";
                $transaction->title = $request->title;
                $transaction->description = $request->description;
                $transaction->currency_id = $request->currency_id;
                $transaction->category_id = 7;
                $transaction->start_date = $request->start_date;
                $transaction->end_date = $request->end_date;
                $transaction->repeat_id = $repeat_id;
                // $transaction->repeat_type = $repeat_type;

                $request->session()->put('valid_transaction', $transaction);
            }
            // // for testing
            // $transaction = Transaction::find(1);
            // $valid_response= true;
            // $array = [
            //     'transaction_details' => $transaction,
            //     'verified' => $valid_response,
            // ];        
            // return response()->json($array,200);
            

        }else{

            $number_of_months = $calculate->numberOfMonths($start_date,$end_date);
            $amount_monthly = $goal_amount/$number_of_months;

            //weekly
            while($start_date < $end_date){

                $number_of_weeks = $calculate->numberOfWeeks($start_date,$end_date);
                $amount_weekly = $goal_amount/$number_of_weeks;

                $number_of_weeks = $calculate->numberOfWeeks($start_date,$end_date);
                $amount = $goal_amount/$number_of_weeks;

                //validate that amount 
                //if valid subtract month from end_date
                //else break
                //else get the last amount and the end_date  
            }
        }

        // $valid_response= false;
        // $valid_response= true;
        // $transaction = Transaction::find(1);

        if($valid_response){
            $array = [
                'transaction_details' => $transaction,
                'verified' => $valid_response,
            ];
        }else{
            $array = [
                'verified' => $valid_response,
            ];
        }
        return response()->json($array,200);
    }

    public function validateSaving(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'goal_amount' => 'required|numeric',
            'amount' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'max:255',
            'currency_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'repeat_id' => 'required|numeric|in:3,4',
            'start_date' => 'required|date',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 401);
        }

        $user = Auth::user();
        $this->calculator = new Calculator($user);
        $calculate = $this->calculator;
        
        $goal_amount_tr = $request->goal_amount;
        $amount_tr = $request->amount;
        $currency_id = $request->currency_id;
        $repeat_id = $request->repeat_id;
        $start_date = $request->start_date;
        
        
        $goal_amount = $calculate->defaultAmount($goal_amount_tr,$currency_id);
        $amount = $calculate->defaultAmount($amount_tr,$currency_id);
        $due_date = $calculate->dueDate($goal_amount,$amount,$start_date,$repeat_id);

        $isValid_goal = $this->goalValid($goal_amount,$due_date);
        $isValid_fequently = $this->frequentlyValid($amount,$start_date,$due_date,$repeat_id);
        
        $valid_response = false;

        if($isValid_goal && $isValid_fequently){
            $valid_response = true;
        }

        $array = [
            'request_params' => $request->all(),
            'end_date' => $due_date,
            'verified' => $valid_response,
        ];

        return response()->json($array,200);
    }
    public function goalValid($goal_amount,$due_date)
    {
        $calculate = $this->calculator;
        
        $overall_balance = $calculate->overallCalculationUntil($due_date);
        $dif = $overall_balance - $goal_amount;

        if($dif<0){
            return false;
        }
        return true;
    }

    public function frequentlyValid($amount,$start_date,$end_date,$repeat_id)
    {
        $calculate = $this->calculator ;
        $start_date = new DateTime($start_date);
        $end_date = new DateTime($end_date);

        $recurrent_save_date = $start_date;
        $saving_number = 1;

        while($recurrent_save_date <= $end_date){

            if($repeat_id == 3){

                $week_overall_before_savings = $calculate->weekOverallCalculation($recurrent_save_date->format('Y-m-d'));
                $amount_saved = $saving_number*$amount;
                $week_overall_after_savings = $week_overall_before_savings - $amount_saved;

                if($amount > ($week_overall_after_savings+$amount)){
                    return false;
                }else{
                    $saving_number++;
                }
                $recurrent_save_date = $recurrent_save_date->add(new DateInterval('P1W'));

            }else if($repeat_id == 4){

                $month_overall_before_savings = $calculate->monthOverallCalculation($recurrent_save_date->format('Y-m-d'));
                $amount_saved = $saving_number*$amount;
                $month_overall_after_savings = $month_overall_before_savings - $amount_saved;

                if($amount > ($month_overall_after_savings+$amount)){
                    return false;
                }else{
                    $saving_number++;
                }
                $recurrent_save_date = $recurrent_save_date->add(new DateInterval('P1M'));
            } 
        }
        return true;
    }

    public function goalAmountFrequentlyValid($goal_amount,$start_date,$end_date,$repeat_id){

        $calculate = new Calculator;
        $valid_info = array();
        
        
        if($repeat_id == 3){
            //weekly
            $number_of_weeks = $calculate->numberOfWeeks($start_date,$end_date);
            $amount_weekly = $goal_amount/$number_of_weeks;
            $weekly_valid = $this->frequentlyValid($amount_weekly,$start_date,$end_date,3); 

            $valid_info['valid'] = $weekly_valid;
            $valid_info['amount'] = $amount_weekly;
            
        }else if($repeat_id == 4){
            //monthly
            
            $number_of_months = $calculate->numberOfMonths($start_date,$end_date);
            $amount_monthly = $goal_amount/$number_of_months;
            $monthly_valid  = $this->frequentlyValid($amount_monthly,$start_date,$end_date,4);

            $valid_info['valid'] = $monthly_valid;
            $valid_info['amount'] = $amount_monthly;
        }else{
            $valid_info['valid'] = false;
            $valid_info['amount'] = 0;
        }

        return $valid_info; 
        //test
        // $valid_info['valid'] = false;
        // $valid_info['amount'] = 0;
        // return $valid_info;
    }
}