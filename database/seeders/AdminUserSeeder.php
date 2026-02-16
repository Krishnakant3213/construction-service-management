<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@construction.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'phone' => '+91 98765 43210',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('super-admin');

        // Create a sample sales executive
        $sales = User::firstOrCreate(
            ['email' => 'sales@construction.test'],
            [
                'name' => 'Rajesh Kumar',
                'password' => Hash::make('password'),
                'phone' => '+91 98765 43211',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $sales->assignRole('sales-executive');

        // Create a sample site engineer
        $engineer = User::firstOrCreate(
            ['email' => 'engineer@construction.test'],
            [
                'name' => 'Amit Singh',
                'password' => Hash::make('password'),
                'phone' => '+91 98765 43212',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $engineer->assignRole('site-engineer');

        // Create a sample accountant
        $accountant = User::firstOrCreate(
            ['email' => 'accountant@construction.test'],
            [
                'name' => 'Priya Sharma',
                'password' => Hash::make('password'),
                'phone' => '+91 98765 43213',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $accountant->assignRole('accountant');
    }
}
