<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lawyer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update or create admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@lexicase.com'],
            [
                'name' => 'Darius',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created/updated successfully!');
        $this->command->info('Name: ' . $admin->name);
        $this->command->info('Email: admin@lexicase.com');
        $this->command->info('Password: password');
    }
}
