<?php

use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
