<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardController;
// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Session;

class IncomeController extends DashboardController
{
    public function index(){
        parent::setDashboardType('income');
        return parent::viewfilteredBySessionTime();
    }

}
