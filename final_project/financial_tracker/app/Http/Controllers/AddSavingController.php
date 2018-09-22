<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use App\User;

use App\CustomClasses\Calculator;

class AddSavingController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('saving_add')->with('user',$user);
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
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $isValid = true;
        
        $goal_amount_tr = $request->goal_amount;
        $amount_tr = $request->amount;
        $currency_id = $request->currency_id;

        $start_date = $request->start_date;
        $due_date = $request->end_date; 
        $repeat_id = $request->repeat_id;
        

        //test due date calculation
        $due_date = $calculate->dueDate($goal_amount,$amount,$start_date,$repeat_id);

        echo $due_date;
        return;
        
        $goal_amount = $calculate->defaultAmount($goal_amount_tr,$currency_id);
        $amount = $calculate->defaultAmount($amount_tr,$currency_id);

        $overall_balance = $calculate->overallCalculationUntil($due_date);

        //$goal_amount should be positive 
        $dif = $overall_balance - $goal_amount;

        if($dif<0){
            $isValid = false;
        }
        
        $isValid_fequently = $this->frequentlyValid($amount,$start_date,$due_date,$repeat_id);

        if($isValid && $isValid_fequently){
            return 'this saving is valid';
        }else{
            return 'this saving is not valid';
        }

            
            
        $_SESSION['saving_valid'] = $request->all(); 
        
        if($_SESSION['saving_valid']){
            unset($_SESSION['saving_valid']); 
        }

        return view('saving_add')->with('user',$user);
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
                $week_overall_after_savings = $week_overall_before_savings - ($saving_number*$amount);
                
                if($amount > $week_overall_after_savings){
                    // echo "You can't afford it on week: ".$saving_number." <br>";
                    return false;
                }else{
                    $saving_number++;
                }
                $recurrent_save_date = $recurrent_save_date->add(new DateInterval('P1W'));

            //if monthly
            }else if($repeat_id == 4){

                $month_overall_before_savings = $calculate->monthOverallCalculation($recurrent_save_date->format('Y-m-d'));
                $month_overall_after_savings = $month_overall_before_savings - ($saving_number*$amount);

                if($amount > $month_overall_after_savings){
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

    public function cancelled()
    {

    }
    public function confirmed(Request $request)
    {
        $calculate = new Calculator;
        $goal_amount = $request->goal_amount;
        $due_date = $request->end_date; 
        $overall_balance = $calculate->overallCalculationUntil($due_date);
        echo $overall_balance;

        
        if($overall_balance >= $goal_amount){
            return 'valid Calculator';
        }else{
            return 'not valid Calculator';
        }

        $user = Auth::user();
        $transaction = new Transaction;
        // $transaction->profile_id = $user->profile->id;
        $transaction->amount = $request->amount;
        // $transaction->type = "saving";
        // $transaction->title = $request->title;
        // $transaction->description = $request->description;
        // $transaction->currency_id = $request->currency_id;
        // $transaction->category_id = $request->category_id;
        $transaction->repeat_id = $request->repeat_id;
        $transaction->start_date = $request->start_date;
        $transaction->end_date = $request->end_date;
        


        //test
        //loop over all weeks or months 
        $t_start_date = new DateTime($transaction->start_date);
        $t_end_date = new DateTime($transaction->end_date);
        $goal_amount = $transaction->amount;
        $frequency_id = $request->repeat_id;
        $overall_balance = $this->overallCalculation();

        echo $t_end_date->format('Y-m-d');

        if($overall_balance >= $goal_amount){
            return 'valid';
        }else{
            return 'not valid';
        }

        // $transaction->save();

        
        // return redirect('/dashboard/incomes/monthly');
    }

    
}
