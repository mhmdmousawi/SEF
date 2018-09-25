<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Session;

class OverviewController extends Controller
{
    public function index()
    {
        if(!Session::get('time_filter')){
            $now = date("Y-m-d");
            $this->setTimeFilter($now);
            // $this->setTimeFilter("2018-10-1");
        }
        

        $time_filter = Session::get('time_filter');
        $type_filter = $time_filter['type_filter'];
        $date_filter = $time_filter['date_filter'];

        // return $this->redirection($type_filter,$date_filter);


        $user = Auth::user();
        $carbon_date = Carbon::createFromFormat('Y-m-d', $date_filter);
        $start_current_week = clone $carbon_date->startOfWeek();
        $end_current_week = clone $carbon_date->endOfWeek();
        // $user = $this->customDuration($user,$start_current_week,$end_current_week);
        return view('dashboard.overview')->with('user',$user)
                                         ->with('dashboard_type','overview');
    }

    private function setTimeFilter($date)
    {
        $type_filter = "monthly";
        $date_filter = $date;

        $time_filter = [
            'type_filter' => $type_filter,
            'date_filter' => $date_filter
        ];
        Session::put('time_filter', $time_filter);
    }

}
