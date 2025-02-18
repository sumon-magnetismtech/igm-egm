<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'super-admin',
            'email' => 'sadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$Yv23GU0TJgJCQn1yjJ4wmeF9SSglJ6KL.5SGq6iTv.26ySZSY.bCW', // sadmin@gmail.com
            'remember_token' => Str::random(10),
        ]);
    }
}
