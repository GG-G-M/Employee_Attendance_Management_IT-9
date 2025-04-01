<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin accounts
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'super.admin@example.com',
                'password' => Hash::make('Admin@1234'),
                'role' => 'admin',
                'key' => 'super-admin-qr-001',
                'phone' => '1234567890',
                'position' => 'System Administrator',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HR Manager',
                'email' => 'hr.manager@example.com',
                'password' => Hash::make('Hr@1234'),
                'role' => 'hr',
                'key' => 'hr-manager-qr-002',
                'phone' => '1234567891',
                'position' => 'Human Resources Manager',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IT Admin',
                'email' => 'it.admin@example.com',
                'password' => Hash::make('It@1234'),
                'role' => 'admin',
                'key' => 'it-admin-qr-003',
                'phone' => '1234567892',
                'position' => 'IT Administrator',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $this->command->info('Successfully seeded:');
        $this->command->info('1. Super Admin (super.admin@example.com) - Admin@1234');
        $this->command->info('2. HR Manager (hr.manager@example.com) - Hr@1234');
        $this->command->info('3. IT Admin (it.admin@example.com) - It@1234');
    }
}