<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'room_id',
        'staff_id',       // Who should do the task (could be from room.assigned_staff_id)
        'created_by',     // Who created the task
        'type',           // cleaning, maintenance, inspection, etc.
        'description',
        'priority',       // low, medium, high
        'status',         // pending, in_progress, completed
        'due_date',
        'completed_at',
        'notes'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function assignedStaff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function creator()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }
}
