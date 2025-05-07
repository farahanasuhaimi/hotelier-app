<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Optional: if you plan to use factories for Staff

class Staff extends Authenticatable
{
    use Notifiable, HasFactory; // Add HasFactory if needed

    protected $fillable = [
        'name',
        'position',
        'status',
        'email',
        'phone',
        'password'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Define role permissions based on position
    public function hasPermission($permission)
    {
        $permissions = $this->getPermissions();
        return in_array($permission, $permissions);
    }

    protected function getPermissions()
    {
        // Define permissions for each position
        $permissions = [
            'Manager' => [
                'manage_rooms',
                'manage_staff',
                'assign_tasks',
                'view_reports',
                'approve_requests'
            ],
            'Supervisor' => [
                'manage_housekeeping',
                'assign_tasks',
                'view_reports'
            ],
            'Housekeeper' => [
                'view_tasks',
                'update_task_status'
            ],
            'Maintenance' => [
                'view_tasks',
                'update_task_status',
                'request_supplies'
            ]
        ];

        return $permissions[$this->position] ?? [];
    }

    // Check if staff can assign tasks to other staff
    public function canAssignTaskTo(Staff $staff)
    {
        $hierarchy = [
            'Manager' => 4,
            'Supervisor' => 3,
            'Maintenance' => 2,
            'Housekeeper' => 1
        ];

        return ($hierarchy[$this->position] ?? 0) > ($hierarchy[$staff->position] ?? 0);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'assigned_staff_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
