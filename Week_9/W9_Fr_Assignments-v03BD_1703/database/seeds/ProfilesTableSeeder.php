<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for( $i = 1 ; $i< 50; $i++){
            
            App\Profile::create([
                'profile_id' => $i,
                'full_name' => $faker->name,
                'display_name' => $faker->name,
                'status' => $faker->title,
                'phone' => rand(1000000,9999999)
            ]);
        }
    }
}
