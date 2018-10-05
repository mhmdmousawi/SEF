<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Currency;
use App\Repeat;
use App\CustomClasses\Calculator;
use Session;

use DateTime;
use DateInterval;

class AddSmartSavingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currencies = Currency::all();
        $repeats = Repeat::all();
        return view('smart_saving.add')->with('user',$user)
                                      ->with('currencies',$currencies)
                                      ->with('repeats',$repeats);
    }

    public function confirmed(Request $request)
    {
        $user = Auth::user();
        $calculate = new Calculator;

        if($request->session()->has('valid_transaction')){
            $transaction = $request->session()->get('valid_transaction');
            $transaction->save();
            $request->session()->forget('valid_transaction');
            return redirect('/dashboard/savings');
        }else{
            return "no smart saving plan to confirm..";
        }
    }

}
