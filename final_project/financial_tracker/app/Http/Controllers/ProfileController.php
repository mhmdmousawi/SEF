<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Currency;
use App\Profile;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currencies = Currency::all();
        return view('profile')->with('user',$user)
                              ->with('currencies',$currencies);
    }

    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'currency_select' => 'exists:currencies,id',
        ]);

        
        $user = Auth::user();
        $profile = Profile::find($user->profile->id);
        $profile->default_currency_id = $request->currency_select;
        $profile->save();


        return redirect("/profile");
    }
}
