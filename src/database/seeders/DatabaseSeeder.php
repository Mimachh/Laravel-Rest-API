<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RolesTableSeeder::class);

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'last_name' => 'Last Name',
            'email' => 'test@example.com',
            'terms' => true,
        ]);


        $this->call(SitesTableSeeder::class);
    }
}
