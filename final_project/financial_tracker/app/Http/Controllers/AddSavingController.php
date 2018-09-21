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
        // $validatedData = $request->validate([
        //     'amount' => 'required|max:255',
        //     'title' => 'required|max:255',
        //     'description' => 'required|max:255',
        //     'currency_id' => 'required|numeric',
        //     'category_id' => 'required|numeric',
        //     'repeat_id' => 'required|numeric|in:3,4',
        //     'start_date' => 'required|date|after:yesterday',
        //     'end_date' => 'nullable|date|after:start_date',
        // ]);

        $calculate = new Calculator;
        $goal_amount = $request->goal_amount;
        $due_date = $request->end_date; 
        $overall_balance = $calculate->overallCalculationUntil($due_date);

        if($overall_balance >= $goal_amount){
            return 'valid';
        }else{
            return 'not valid';
        }
    }

    public function create(Request $request)
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
