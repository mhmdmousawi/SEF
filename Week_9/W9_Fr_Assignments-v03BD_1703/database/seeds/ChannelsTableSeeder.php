<?php

use Illuminate\Database\Seeder;

class ChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $channels_ids = App\Channel::all()->pluck('id')->toArray();

        for( $i = 1 ; $i< 50; $i++){
            
            App\Participant::create([
                'channel_id' => $faker->randomElement($channels_ids),
                'profile_id' => $faker->randomElement($profiles_ids)
            ]);
        }
    }
}
