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
            
            App\Profile::create([
                'profile_id' => $i,
                'full_name' => $faker->name,
                'display_name' => $faker->name,
                'status' => $faker->title,
                'phone' => rand(1000000,9999999)
            ]);
        }

        $profiles_ids = App\Profile::all()->pluck('profile_id')->toArray();

        for( $i = 1 ; $i< 5; $i++){
            
            App\Channel::create([
                'name' => $faker->name,
                'purpose' => $faker->sentence,
                'creator_id' => $faker->randomElement($profiles_ids)
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
