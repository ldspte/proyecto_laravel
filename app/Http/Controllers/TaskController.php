<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['project', 'assignedUser'])->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        return view('tasks.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'status' => ['required', Rule::in(['pendiente', 'en_progreso', 'completada'])],
            'priority' => 'required|in:baja,media,alta,critica',
            'estimated_hours' => 'nullable|numeric|min:0.25|max:100',
            'actual_hours' => 'nullable|numeric',
            'project_id' => 'required|exists:projects,id',
            'assigned_user_id' => 'required|exists:users,id'
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Tarea creada exitosamente');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        $users = User::all();
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'status' => ['required', Rule::in(['pendiente', 'en_progreso', 'completada'])],
            'project_id' => 'required|exists:projects,id',
            'assigned_user_id' => 'required|exists:users,id',
            'priority' => 'required|in:baja,media,alta,critica',
            'estimated_hours' => 'nullable|numeric|min:0.25|max:100',
            'actual_hours' => 'nullable|numeric',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada exitosamente');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada exitosamente');
    }

    public function getUserTasks(User $user)
    {
        $tasks = $user->assignedTasks()->with('project')->get();
        return view('tasks.user-tasks', compact('user', 'tasks'));
    }
}
