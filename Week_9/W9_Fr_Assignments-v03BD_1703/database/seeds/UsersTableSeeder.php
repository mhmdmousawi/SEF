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

        for( $i = 1 ; $i< 50; $i++){

            App\User::create([
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password')
            ]);
        }
    }
}
