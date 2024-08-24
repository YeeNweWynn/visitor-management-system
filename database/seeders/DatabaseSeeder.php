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
        $user = User::factory()->create();

        $visitors = Visitor::factory(12)->for($user)->create();

        foreach ($visitors->take(6) as $visitor) {
            CheckIn::factory()->for($user)->for($visitor)->create();
        }
    }
}
