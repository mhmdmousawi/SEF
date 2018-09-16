<?php

use Illuminate\Database\Seeder;

class RepeatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['fixed', 'daily','weekly','monthly'];
        
        for( $i = 0 ; $i < 4 ; $i++ ){
            DB::table('repeats')->insert([
                'type' => $types[$i],
            ]);
        }
    }
}
