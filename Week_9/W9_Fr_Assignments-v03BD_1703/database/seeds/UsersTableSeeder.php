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
        // factory(App\User::class, 50)->create()->each(function ($user) {
        //     $user->profile()->save(
        //         factory(App\Profile::class)->create()->each(function ($profile) {
        //             $profile->channel()->save(
        //                 factory(App\Channel::class)->make()
        //             );
        //         })
        //     );
        // });
        $faker = Faker::create();
        $names = ['samir','mhmd','ali','harout','yasmine','zeinab','samira'];

        for( $i = 1 ; $i< 50; $i++){

            App\User::create([
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password')
            ]);

        }

        $users_ids = App\User::all()->pluck('id')->toArray();

        for( $i = 1 ; $i< 50; $i++){
            App\Profile::create([
                'profile_id' => $users_ids[$i]
            ]);
        }
    }
}
