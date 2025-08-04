<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'client_name',
        'start_date',
        'end_date',
        'budget',
        'status',
        'team_id',
    ];

    // Relación con el modelo Team
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // Relación con el modelo Task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function hasRole($roleName)
    {
        return $this->role->name === $roleName;
    }
}
