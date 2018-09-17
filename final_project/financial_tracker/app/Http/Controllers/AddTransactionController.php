<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddTransactionController extends Controller
{
    public function basic(){

        $user = Auth::user();
        return view('transaction_add')->with('user',$user);
    }
    //validate inputs

    public function details(Request $request)
    {
        print_r ($request->all());
        return "hbb";

    }
}
