<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description',
        'status',
        'priority',
        'estimated_hours',
        'actual_hours',
        'due_date',
        'project_id',
        'assigned_user_id' 
    ];

    /**
     * Relación con el proyecto
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relación con el usuario asignado
     */
    public function assignedUser ()
    {
        return $this->belongsTo(User::class, 'assigned_user_id'); 
    }
}


