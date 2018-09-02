<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ChatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $participants_ids = App\Participant::all()->pluck('id')->toArray();
        $profiles_ids = App\Profile::all()->pluck('profile_id')->toArray();

        for( $i = 1 ; $i< 50; $i++){
            
            App\Chat::create([
                'participant_id' => $faker->randomElement($participants_ids),
                'content' => $faker->sentence
            ]);

            App\ChatDm::create([
                'sender_id' => $faker->randomElement($profiles_ids),
                'reciever_id' => $faker->randomElement($profiles_ids),
                'content' => $faker->sentence
            ]);
        }
    }
}
