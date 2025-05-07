<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Task;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/TaskSeeder.php
    public function run()
    {
        $taskTypes = ['cleaning', 'maintenance', 'inspection', 'linen_change', 'stock_check'];
        $priorities = ['low', 'medium', 'high'];

        // Get all rooms that need cleaning or maintenance
        $rooms = Room::whereIn('status', ['needs_cleaning', 'maintenance'])->get();

        foreach ($rooms as $room) {
            Task::create([
                'room_id' => $room->id,
                'staff_id' => $room->assigned_staff_id, // Default to room's assigned staff
                'created_by' => Staff::where('position', 'Manager')->first()->id,
                'type' => $room->status === 'needs_cleaning' ? 'cleaning' : 'maintenance',
                'description' => $room->status === 'needs_cleaning'
                    ? 'Standard room cleaning'
                    : 'Maintenance check',
                'priority' => $priorities[array_rand($priorities)],
                'status' => 'pending',
                'due_date' => now()->addHours(rand(1, 12)),
                'notes' => $room->notes // Carry over any room notes
            ]);
        }

        // Add some random additional tasks
        for ($i = 0; $i < 5; $i++) {
            $randomRoom = Room::inRandomOrder()->first();

            Task::create([
                'room_id' => $randomRoom->id,
                'staff_id' => $randomRoom->assigned_staff_id,
                'created_by' => Staff::inRandomOrder()->first()->id,
                'type' => $taskTypes[array_rand($taskTypes)],
                'description' => 'Additional task for room ' . $randomRoom->room_number,
                'priority' => $priorities[array_rand($priorities)],
                'status' => rand(0, 1) ? 'pending' : 'in_progress',
                'due_date' => now()->addDays(rand(1, 3)),
                'completed_at' => rand(0, 1) ? now()->subDays(rand(1, 2)) : null
            ]);
        }
    }
}
