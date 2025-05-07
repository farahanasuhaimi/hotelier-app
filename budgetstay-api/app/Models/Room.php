<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'type',
        'status',
        'last_cleaned_at',
        'assigned_staff_id',
        'notes'
    ];

    protected $casts = [
        'last_cleaned_at' => 'datetime',
    ];

    public function assignedStaff()
    {
        return $this->belongsTo(Staff::class, 'assigned_staff_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function pendingTasks()
    {
        return $this->tasks()->where('status', '!=', 'completed');
    }

    public function completedTasks()
    {
        return $this->tasks()->where('status', 'completed');
    }

    public function highPriorityTasks()
    {
        return $this->tasks()->where('priority', 'high');
    }

    // Automatically create cleaning task when status changes
    protected static function booted()
    {
        static::updated(function ($room) {
            if ($room->wasChanged('status') && $room->status === 'needs_cleaning') {
                $room->tasks()->create([
                    'staff_id' => $room->assigned_staff_id,
                    'created_by' => auth()->id() ?? Staff::where('position', 'System')->first()?->id ?? Staff::where('position', 'Manager')->first()?->id,
                    // Ensure these staff members exist or handle the null case gracefully.
                    'type' => 'cleaning',
                    'description' => 'Routine cleaning',
                    'priority' => 'medium',
                    'status' => 'pending',
                    'due_date' => now()->addHours(6)
                ]);
            }
        });
    }
}
