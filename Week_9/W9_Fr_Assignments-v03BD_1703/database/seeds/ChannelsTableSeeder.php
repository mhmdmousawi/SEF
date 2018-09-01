<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $profiles_ids = App\Profile::all()->pluck('profile_id')->toArray();

        for( $i = 1 ; $i< 5; $i++){
            
            App\Channel::create([
                'name' => $faker->name,
                'purpose' => $faker->sentence,
                'creator_id' => $faker->randomElement($profiles_ids)
            ]);
        }
    }
}
