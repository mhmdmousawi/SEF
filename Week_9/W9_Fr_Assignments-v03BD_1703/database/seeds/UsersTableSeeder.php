<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $names = ['samir','mhmd','ali','harout','yasmine','zeinab','samira'];

        for( $i = 1 ; $i< 50; $i++){

            App\User::create([
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password')
            ]);
            
        }

        $channels_ids = App\Channel::all()->pluck('id')->toArray();

        for( $i = 1 ; $i< 50; $i++){
            
            App\Participant::create([
                'channel_id' => $faker->randomElement($channels_ids),
                'profile_id' => $faker->randomElement($profiles_ids)
            ]);
        }
        

        

        $participants_ids = App\Participant::all()->pluck('id')->toArray();

        for( $i = 1 ; $i< 50; $i++){
            
            App\Chat::create([
                'participant_id' => $faker->randomElement($participants_ids),
                'content' => $faker->sentence
            ]);
        }

        

    }
}
