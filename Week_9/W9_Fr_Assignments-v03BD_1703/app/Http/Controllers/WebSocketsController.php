<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mylibs\ChatHandler;
use App\Mylibs\ChatHandlerForUnroutedUrls;
use App\Mylibs\WebSocketStarter;

class WebSocketsController extends Controller
{
    //we need to open a ws connection
    public function start(Request $request){
        
        $ws = new WebSocketStarter;
        $ws->start();
    }
    public function index(){

        return view('test_ws');
    }
}
