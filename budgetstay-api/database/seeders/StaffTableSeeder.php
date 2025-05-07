<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $staffNames = ['Maria S.', 'John D.', 'Lisa M.', 'Carlos R.', 'Anna K.'];
        $positions = ['Housekeeper', 'Supervisor', 'Manager', 'Maintenance'];
        $statuses = ['available', 'on_duty', 'on_break', 'off_duty'];

        foreach ($staffNames as $name) {
            Staff::create([
                'name' => $name,
                'position' => $positions[array_rand($positions)],
                'status' => $statuses[array_rand($statuses)],
                'email' => strtolower(str_replace(' ', '.', $name)) . '@budgetstay.com',
                'phone' => '555-' . rand(100, 999) . '-' . rand(1000, 9999),
                'password' => Hash::make('password123'), // Default password
            ]);
        }

        // Create a specific admin for testing
        Staff::create([
            'name' => 'Admin User',
            'position' => 'Manager',
            'status' => 'available',
            'email' => 'admin@budgetstay.com',
            'phone' => '555-123-4567',
            'password' => Hash::make('admin123'),
        ]);
    }
}
