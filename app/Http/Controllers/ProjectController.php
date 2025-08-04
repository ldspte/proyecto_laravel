<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
/**
 * @OA\Info(title="API Gestión de Proyectos", version="1.0")
 */

class ProjectController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/projects",
     *     summary="Lista todos los proyectos",
     *     tags={"Proyectos"},
     *     @OA\Response(
     *         response=200,
     *         description="Listado de proyectos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="status", type="string")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {

        $projects = Project::with(['team', 'tasks'])->get();
        return view('projects.index', compact('projects'));
    }
    /**
     * @OA\Post(
     *     path="/api/projects",
     *     summary="Crea un nuevo proyecto",
     *     tags={"Proyectos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "status"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="team_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Proyecto creado"),
     *     @OA\Response(response=400, description="Solicitud incorrecta")
     * )
     */

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
     /**
     * @OA\Get(
     *     path="/api/projects/{id}",
     *     summary="Obtiene un proyecto específico",
     *     tags={"Proyectos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Proyecto encontrado"),
     *     @OA\Response(response=404, description="Proyecto no encontrado")
     * )
     */

    public function show(Project $project)
    {
        $project->load(['team.members', 'tasks.assignedUser']);
        return view('projects.show', compact('project'));
    }
    /**
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     summary="Actualiza un proyecto existente",
     *     tags={"Proyectos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     * *             required={"name", "status"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="team_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Proyecto actualizado"),
     *     @OA\Response(response=404, description="Proyecto no encontrado")
     * )
     */

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

    /**
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     summary="Elimina un proyecto",
     *     tags={"Proyectos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Proyecto eliminado"),
     *     @OA\Response(response=404, description="Proyecto no encontrado")
     * )
     */

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

