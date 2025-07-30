<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'team_leader_id'
    ];

    // Relación con el modelo Project
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Relación con el modelo User (si tienes un modelo User)
    public function users()
    {
        return $this->belongsToMany(User::class, 'team_leader_id');
    }
}
