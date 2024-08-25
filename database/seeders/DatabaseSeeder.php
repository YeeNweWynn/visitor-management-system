<?php

namespace Database\Seeders;

use App\Models\CheckIn;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        $visitors = Visitor::factory(20)->for($user)->create();

        /** 
         * These visitors have not checked out yet.
         */
        foreach ($visitors->take(5) as $visitor) {
            CheckIn::factory()->for($user)->for($visitor)->create();
        }

        /** 
         * These visitors have already checked out.
         */
        foreach ($visitors->skip(5)->take(5) as $visitor) {
            CheckIn::factory()->for($user)->for($visitor)->checkedOut()->create();
        }
    }
}
