<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Activity;

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

        for ($i = 0; $i < 10; $i++) {
            Activity::create([
                'type' => $types[array_rand($types)],
                'description' => $descriptions[array_rand($descriptions)],
                'room_id' => rand(1, 24),
                'staff_id' => rand(1, 5),
                'completed_at' => rand(0, 1) ? now()->subHours(rand(1, 24)) : null,
            ]);
        }
    }
}
