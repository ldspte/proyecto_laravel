<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['team', 'tasks'])->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $teams = Team::all();
        $users = User::all();
        return view('projects.create', compact('teams', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'client_name' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'required|numeric|min:0',
            'status' => 'required|in:planning,in_progress,completed,on_hold',
            'team_id' => 'required|exists:teams,id'
        ]);

        DB::transaction(function () use ($validated) {
            $project = Project::create($validated);
            // Aquí puedes agregar lógica adicional como asignar usuarios al proyecto
        });

        return redirect()->route('projects.index')->with('success', 'Proyecto creado exitosamente');
    }

    public function show(Project $project)
    {
        $project->load(['team.members', 'tasks.assignedUser']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $teams = Team::all();
        return view('projects.edit', compact('project', 'teams'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'client_name' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'required|numeric|min:0',
            'status' => 'required|in:planning,in_progress,completed,on_hold',
            'team_id' => 'required|exists:teams,id'
        ]);

        $project->update($validated);
        return redirect()->route('projects.index')->with('success', 'Proyecto actualizado exitosamente');
    }

    public function destroy(Project $project)
    {
        DB::transaction(function () use ($project) {
            $project->tasks()->delete(); // Elimina tareas relacionadas
            $project->delete();
        });

        return redirect()->route('projects.index')->with('success', 'Proyecto eliminado exitosamente');
    }

    public function assignUsers(Request $request, Project $project)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        // Sincroniza usuarios adicionales (no reemplaza al equipo)
        $project->additionalUsers()->syncWithoutDetaching($validated['user_ids']);

        return back()->with('success', 'Usuarios asignados al proyecto correctamente');
    }
}

