<?php

namespace App;
use DateTime;
use DateInterval;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User','id');
    }

    public function defaultCurrency()
    {
        return $this->belongsTo('App\Currency','default_currency_id');
    }

    public function categories()
    {
        return $this->hasMany('App\Category','profile_id','id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction','profile_id','id');
    }

    public function transactionsWithType($type)
    {
        $transactions = $this->transactions()
                             ->where("type",$type)
                             ->get();
        return $transactions;
    }

    
    public function transactionInTimeFrame($type)
    {

        $s_date = '2018-9-1';
        $e_date = '2018-9-20';

        $transactions = $this->transactionsWithType($type);

        // $start_date = strtotime($s_date);
        // $end_date = strtotime($e_date);

        $ss_date = new DateTime($s_date);
        $se_date = new DateTime($e_date);
        
        $i = 0;
        $filtered_transactions = [];
        foreach ($transactions as $transaction) {

            $ts_date = new DateTime($transaction->start_date);
            $te_date = new DateTime($transaction->end_date);


            if($transaction->repeat->type == 'fixed'){
                
                if($ts_date > $ss_date && $ts_date < $se_date ){
                    $filtered_transactions[$i++] = $transaction;
                }
                
            }else {
            
                $recurrent_date = $ts_date;

                while($recurrent_date > $ss_date && $recurrent_date <= $se_date){

                    $transaction->start_date = $recurrent_date->format('Y-m-d');
                    $filtered_transactions[$i++] = clone $transaction;
                
                    if($transaction->repeat->type == 'daily'){
                        $recurrent_date = $recurrent_date->add(new DateInterval('P1D'));
                    }else if($transaction->repeat->type = 'weekly'){
                        $recurrent_date = $recurrent_date->add(new DateInterval('P1W'));
                    }else if($transaction->repeat->type = 'monthly'){
                        $recurrent_date = $recurrent_date->add(new DateInterval('P1M'));
                    }
                }
            }
            
        }
        return json_encode($filtered_transactions);
    }

}
