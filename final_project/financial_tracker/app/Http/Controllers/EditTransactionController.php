<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use DateTime;
use DateInterval;

class EditTransactionController extends Controller
{
    public function index(Request $request)
    {
        $transaction_id = $request->id;
        $transaction = Transaction::find($transaction_id);

        if(!$transaction){
           return '404 page';
        }
        return view('transaction_edit')->with('transaction',$transaction);
    }

    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'currency_id' => 'required|numeric',
            'edit_type' => 'required',
        ]);

        $edit_type = $request->edit_type;
        $transaction_id = $request->id;
        $transaction = Transaction::find($transaction_id);

        if(!$transaction){
            return '404 page';
        }

        $t_end_date = new DateTime($transaction->end_date);
        $t_start_date = new DateTime($transaction->start_date);
        $today = new Datetime (date("Y-m-d"));

        if($t_end_date <= $today){
            //send error 
            return redirect('/edit/transaction?id='.$transaction->id);
        }else if($t_start_date == $today){
            $edit_type = "all";
        }

        if($edit_type == "future"){

            $new_transaction = new Transaction;
            $new_transaction->profile_id = $transaction->profile_id; //same
            $new_transaction->amount = $request->amount;
            $new_transaction->type = $transaction->type; //same
            $new_transaction->title = $request->title;
            $new_transaction->description = $request->description;
            $new_transaction->currency_id = $request->currency_id;
            $new_transaction->category_id = $transaction->category_id; //same
            $new_transaction->repeat_id = $transaction->repeat_id; //same

            $next_start_date = $this->getNextStartDate($transaction);
            $new_transaction->start_date = $next_start_date;
            $new_transaction->end_date = $transaction->end_date; //same
            $new_transaction->save();

            $transaction->end_date = $next_start_date;
            $transaction->save();

            return $this->redirection($transaction);

        }else if($edit_type == "all"){

            $transaction->amount = $request->amount;
            $transaction->title = $request->title;
            $transaction->description = $request->description;
            $transaction->currency_id = $request->currency_id;
            $transaction->save();

            return $this->redirection($transaction);

        }else{
            return "404 page";
        }

    }

    public function redirection($transaction)
    {
        if($transaction->type == "income"){
            return redirect('/dashboard/incomes/monthly');
        }else if ($transaction->type == "expense"){
            return redirect('/dashboard/expenses/monthly');
        }else{
            return "404 page";
        }
    }

    public function getNextStartDate($transaction){

        $t_start_date = $transaction->start_date;
        $t_end_date =$transaction->end_date;
        $t_repeat_id = $transaction->repeat_id;

        $next_start_date = new DateTime($t_start_date);
        $today = new DateTime(date("Y-m-d"));
        
        while($next_start_date < $today){
            if($transaction->repeat->type == 'daily'){
                $next_start_date = $next_start_date->add(new DateInterval('P1D'));
            }else if($transaction->repeat->type = 'weekly'){
                $next_start_date = $next_start_date->add(new DateInterval('P1W'));
            }else if($transaction->repeat->type = 'monthly'){
                $next_start_date = $next_start_date->add(new DateInterval('P1M'));
            }
        }
        return $next_start_date->format("Y-m-d");
    }
}
