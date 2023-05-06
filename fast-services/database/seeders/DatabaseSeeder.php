<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use \App\Models\User;
use \App\Models\Mechanic;
use \App\Models\Service;
use \App\Models\Rating;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::truncate();
        Mechanic::truncate();
        Service::truncate();
        Rating::truncate();

        //User::factory(5)->create();
        Mechanic::factory(5)->create();

        $user = User::create([
            'name' => 'Zarko1',
            'email' => 'zarko1@gmail.com',
            'password' => Hash::make('Zarko*1998'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'admin'
        ]);

        $service1 = Service::create([
            'name' => 'Zamena guma'
        ]);

        $service2 = Service::create([
            'name' => 'Amortizeri popravka'
        ]);

        $service3 = Service::create([
            'name' => 'Zamena akumulatora'
        ]);

        $service4 = Service::create([
            'name' => 'Servo popravka'
        ]);

        $service5 = Service::create([
            'name' => 'Veliki servis'
        ]);

        $rating1 = Rating::create([
            'date_and_time' => now(),
            'user' => 2,
            'service' => 1,
            'rating' => 5,
            'note' => 'Odlicna zamena, vrlo efikasno!',
            'mechanic' => 1  
        ]);

        $rating2 = Rating::create([
            'date_and_time' => now(),
            'user' => 3,
            'service' => 1,
            'rating' => 5,
            'note' => 'Servo zamena po prihvatljivoj ceni uz dosta profesionalizma.',
            'mechanic' => 2
        ]);
    }
}
