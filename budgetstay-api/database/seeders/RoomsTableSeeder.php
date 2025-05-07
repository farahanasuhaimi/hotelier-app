<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = ['Single', 'Double', 'Dorm (6 beds)', 'Family', 'Suite'];
        $statuses = ['ready', 'needs_cleaning', 'occupied', 'in_cleaning', 'maintenance'];

        for ($i = 1; $i <= 24; $i++) {
            Room::create([
                'room_number' => ($i < 10 ? '10' : '20') . $i,
                'type' => $roomTypes[array_rand($roomTypes)],
                'status' => $statuses[array_rand($statuses)],
                'last_cleaned_at' => now()->subDays(rand(0, 3))->subHours(rand(1, 8)),
                'assigned_staff_id' => rand(1, 5),
            ]);
        }
    }
}
