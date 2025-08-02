<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;


// Rutas para Tareas
Route::resource('tasks', TaskController::class);
Route::get('users/{user}/tasks', [TaskController::class, 'getUserTasks'])->name('users.tasks');

// Rutas para Usuarios
Route::resource('users', UserController::class);

// Rutas para Proyectos
Route::resource('projects', ProjectController::class);
Route::post('projects/{project}/assign-users', [ProjectController::class, 'assignUsers'])->name('projects.assign-users');
// Rutas para Equipos
Route::resource('teams', TeamController::class);
Route::post('teams/{team}/add-members', [TeamController::class, 'addMembers'])->name('teams.add-members');

