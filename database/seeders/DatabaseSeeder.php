<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'role' => 'ROLE_ADMIN',
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime
        ]);
        DB::table('roles')->insert([
            'role' => 'ROLE_SUPERVISOR',
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime
        ]);
        DB::table('roles')->insert([
            'role' => 'ROLE_BASIC',
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime
        ]);
    }
}
