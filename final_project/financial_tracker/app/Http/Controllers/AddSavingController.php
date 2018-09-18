<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;

class AddSavingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('saving_add')->with('user',$user);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|max:255',
            // 'type' => 'required|in:income,expense,saving',
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'currency_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'repeat_id' => 'required|numeric|in:3,4',
            'start_date' => 'required|date|after:yesterday',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $user = Auth::user();
        $transaction = new Transaction;
        $transaction->profile_id = $user->profile->id;
        $transaction->amount = $request->amount;
        $transaction->type = "saving";
        // $transaction->type = $request->type;
        $transaction->title = $request->title;
        $transaction->description = $request->description;
        $transaction->currency_id = $request->currency_id;
        $transaction->category_id = $request->category_id;
        $transaction->repeat_id = $request->repeat_id;
        $transaction->start_date = $request->start_date;
        $transaction->end_date = $request->end_date;
        $transaction->save();

        
        return redirect('/dashboard/incomes/monthly');
    }
}
