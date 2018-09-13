<?php

use Illuminate\Database\Seeder;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<10;$i++){
            $transaction = new App\Transaction;
            $transaction->profile_id = "1";
            if($i <5){
                $transaction->type = 'income';
            }else{
                $transaction->type = 'expense';
            }
            $transaction->description = "This is an example on income description";
            $transaction->amount = 200;
            $transaction->currency_id = 1;
            $transaction->category_id = 1;
            $transaction->repeat_id = 1;
            $transaction->start_date = date_create("2018-9-13");
            $transaction->end_date = date_create("2018-10-13");
            $transaction->save();
        }
    }
}
