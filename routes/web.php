<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\RoleController;



Route::get('/', function () {
    return redirect()->route('login'); // Asegúrate de que 'login' sea el nombre de la ruta de inicio de sesión
});

Route::middleware(['auth'])->group(function () {
    Route::resource('roles', RoleController::class);
    // Rutas comunes para todos los usuarios autenticados
    Route::get('/profile', [ProfileController::class, 'show']);
    
    // Rutas específicas por rol
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
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
    });

    Route::middleware(['role:Project Manager'])->group(function(){
        // Rutas para Proyectos
        Route::resource('projects', ProjectController::class);
        Route::post('projects/{project}/assign-users', [ProjectController::class, 'assignUsers'])->name('projects.assign-users');
        // Rutas para Equipos
        Route::resource('teams', TeamController::class);
        Route::post('teams/{team}/add-members', [TeamController::class, 'addMembers'])->name('teams.add-members');
    });

    Route::middleware(['role:Developer'])->group(function(){
        // Rutas para Equipos
        Route::resource('teams', TeamController::class);
        Route::post('teams/{team}/add-members', [TeamController::class, 'addMembers'])->name('teams.add-members');
    });

});





Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
