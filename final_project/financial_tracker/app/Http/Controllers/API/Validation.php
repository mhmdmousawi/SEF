<?php

namespace App\Http\Controllers\API;

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


class Validation extends Controller
{
    private $calculator;

    public function validateSaving(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
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

        $user_id = $request->user_id;
        $user = User::find($user_id);

        $this->calculate = new Calculator($user);
        $calculate = $this->calculate;

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
        $calculate = $this->calculate ;
        $overall_balance = $calculate->overallCalculationUntil($due_date);
        $dif = $overall_balance - $goal_amount;

        if($dif<0){
            return false;
        }
        return true;
    }

    public function frequentlyValid($amount,$start_date,$end_date,$repeat_id)
    {
        $calculate = $this->calculate ;
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
}