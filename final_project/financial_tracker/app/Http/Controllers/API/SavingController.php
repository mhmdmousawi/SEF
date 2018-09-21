<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use App\User;

use App\CustomClasses\Calculator;

class SavingController extends Controller
{
    public function validateSaving(Request $request)
    {
        $calculate = new Calculator;

        //info needed
        $goal_amount = $request->goal_amount;
        $due_date = $request->end_date;

        $overall_balance = $calculate->overallCalculationUntil($due_date);


        $response_array = array(
            'valid' => 'true',
        );
        $response_data = json_encode(array('item' => $post_data));
    }
}
