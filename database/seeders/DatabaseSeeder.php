<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Role;
use App\Models\UserDetail;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::factory()->create();
        $supervisorRole = Role::factory()->supervisor()->create();
        $basicRole = Role::factory()->basic()->create();
        User::factory(1000)->create()->each(function ($user) use ($adminRole, $supervisorRole, $basicRole) {
            $user->roles()->attach($adminRole);
            $user->roles()->attach($supervisorRole);
            $user->roles()->attach($basicRole);
            $user->userDetails()->save(UserDetail::factory()->make());
        });
        
    }
}
