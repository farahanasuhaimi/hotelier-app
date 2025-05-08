<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Staff;
use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $types = ['cleaning', 'staff', 'maintenance', 'room'];
        $descriptions = [
            'Room 101 cleaned',
            'New staff member added',
            'Maintenance reported',
            'New room added',
            'Room inspection completed',
            'Guest complaint resolved'
        ];
        $randomRoom = Room::inRandomOrder()->first();
        $randomStaff = Staff::inRandomOrder()->first();

        for ($i = 0; $i < 10; $i++) {
            Activity::create([
                'type' => $types[array_rand($types)],
                'description' => $descriptions[array_rand($descriptions)],
                'room_id' => $randomRoom ? $randomRoom->id : null, // Handle if no rooms/staff exist
                'staff_id' => $randomStaff ? $randomStaff->id : null,
                'completed_at' => rand(0, 1) ? now()->subHours(rand(1, 24)) : null,
            ]);
        }
    }
}
