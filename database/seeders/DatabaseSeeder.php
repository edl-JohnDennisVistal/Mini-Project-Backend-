<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Role;
use App\Models\UserDetail;
use App\Models\Skill;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Skill::factory()->create();
        Skill::factory()->c()->create();
        Skill::factory()->chash()->create();
        Skill::factory()->php()->create();
        Skill::factory()->swift()->create();
        Skill::factory()->python()->create();
        Skill::factory()->java()->create();
        Skill::factory()->javascript()->create();
        Skill::factory()->ruby()->create();
        $adminRole = Role::factory()->create();
        $supervisorRole = Role::factory()->supervisor()->create();
        $basicRole = Role::factory()->basic()->create();
        User::factory(50)->create()->each(function ($user) use ($adminRole, $supervisorRole, $basicRole) {
            $user->roles()->attach($adminRole);
            $user->roles()->attach($supervisorRole);
            $user->roles()->attach($basicRole);
            $user->userDetails()->save(UserDetail::factory()->make());
        });
        
    }
}
