<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use App\User;
use Session;

use App\CustomClasses\Calculator;

class AddSavingController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('saving.add')->with('user',$user);
    }

    public function validateSaving(Request $request)
    {

        $user = Auth::user();
        $calculate = new Calculator;

        $validatedData = $request->validate([
            'goal_amount' => 'required|max:255',
            'amount' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'currency_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'repeat_id' => 'required|numeric|in:3,4',
            'start_date' => 'required|date',
        ]);

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


        if($isValid_goal && $isValid_fequently){

            $user->saving_validation = "valid"; 
            $session_data = $request->all();
            $session_data['end_date'] = $due_date;
            Session::put('saving_valid', $session_data);
        }else{
           $user->saving_validation = "invalid"; 
        }

        return view('saving_confirm')->with('user',$user);

    }

    public function goalValid($goal_amount,$due_date)
    {
        $calculate = new Calculator;
        $overall_balance = $calculate->overallCalculationUntil($due_date);
        $dif = $overall_balance - $goal_amount;

        if($dif<0){
            return false;
        }
        return true;
    }

    public function frequentlyValid($amount,$start_date,$end_date,$repeat_id)
    {
        $calculate = new Calculator;
        $start_date = new DateTime($start_date);
        $end_date = new DateTime($end_date);

        $recurrent_save_date = $start_date;
        $saving_number = 1;

        while($recurrent_save_date <= $end_date){
            //if weekly
            if($repeat_id == 3){

                $week_overall_before_savings = $calculate->weekOverallCalculation($recurrent_save_date->format('Y-m-d'));
                $amount_saved = $saving_number*$amount;
                $week_overall_after_savings = $week_overall_before_savings - $amount_saved;
                
                // echo "week_overall_before_savings: ". $week_overall_before_savings . "<br>";
                // echo "week_overall_after_savings: ". $week_overall_after_savings . "<br>";
                // echo "amount_saved: ". $amount_saved . "<br>";

                if($amount > ($week_overall_after_savings+$amount)){
                    // echo "You can't afford it on week: ".$saving_number." <br>";
                    return false;
                }else{
                    $saving_number++;
                }
                $recurrent_save_date = $recurrent_save_date->add(new DateInterval('P1W'));

            //if monthly
            }else if($repeat_id == 4){

                $month_overall_before_savings = $calculate->monthOverallCalculation($recurrent_save_date->format('Y-m-d'));
                $amount_saved = $saving_number*$amount;
                $month_overall_after_savings = $month_overall_before_savings - $amount_saved;

                // echo "month_overall_before_savings: ". $month_overall_before_savings . "<br>";
                // echo "month_overall_after_savings: ". $month_overall_after_savings . "<br>";
                // echo "amount_saved: ". $amount_saved . "<br>";

                if($amount > ($month_overall_after_savings+$amount)){
                    // echo "You can't afford it on month: ".++$saving_number." <br>";
                    return false;
                }else{
                    $saving_number++;
                }
                $recurrent_save_date = $recurrent_save_date->add(new DateInterval('P1M'));
            } 
        }
        // echo "You can afford this saving <br>";
        return true;
    }

    
    public function confirm(Request $request)
    {
        $user = Auth::user();
        if(isset($request->confirm)){
            if(Session::get('saving_valid')){

                $session_data = Session::get('saving_valid');
                $transaction = new Transaction;
                $transaction->profile_id = $user->profile->id;
                $transaction->amount = $session_data['amount'];
                $transaction->type = "saving";
                $transaction->title = $session_data['title'];
                $transaction->description = $session_data['description'];
                $transaction->currency_id = $session_data['currency_id'];
                $transaction->category_id = $session_data['category_id'];
                $transaction->repeat_id = $session_data['repeat_id'];
                $transaction->start_date = $session_data['start_date'];
                $transaction->end_date = $session_data['end_date'];
                $transaction->save();

                Session::forget('saving_valid');

            }
        }else if(isset($request->cancel)){
            return view('saving_add')->with('user',$user);
        }else{
            return "Some Error Happened";
        }
        

        return redirect('/dashboard/savings/monthly');
    }

    
}
