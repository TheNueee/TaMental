<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'adminjawa',
            'email' => 'adminjawa@gmail.com',
            'password' => Hash::make('jawajawajawa'),
            'role' => 'admin',
            'email_verified_at' => now()
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now()
        ]);

        User::factory()->create([
            'name' => 'profesional',
            'email' => 'profesional@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'professional',
            'email_verified_at' => now()
        ]);
    }
}
