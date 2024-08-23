<?php

namespace Database\Seeders;

use App\Models\CheckIn;
use App\Models\User;
use App\Models\Visitor;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $vistors = Visitor::factory(10)->for($users)->create();

        // $user = User::factory()->has(Visitor::factory()->count(10))->create();
        // $user = User::find(1);
        // $visitor = Visitor::find(1);

        // CheckIn::factory(10)->for($user)->for($visitor)->create();

        $user = User::factory()->create();

        $visitors = Visitor::factory(12)->for($user)->create();

        foreach ($visitors->take(6) as $visitor) {
            CheckIn::factory()->for($user)->for($visitor)->create();
        }
    }
}
