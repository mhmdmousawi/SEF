<?php

use Illuminate\Database\Seeder;

class LogoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<5;$i++){
            DB::table('logos')->insert([
                'class_name' => "class ".$i,
            ]);
        }
    }
}
