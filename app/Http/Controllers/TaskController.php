<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @OA\Tag(
 *     name="Tareas",
 *     description="Operaciones relacionadas con tareas"
 * )
 */

class TaskController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Lista todas las tareas",
     *     tags={"Tareas"},
     *     @OA\Response(
     *         response=200,
     *         description="Listado de tareas",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Corregir bug"),
     *                 @OA\Property(property="status", type="string", example="pendiente"),
     *                 @OA\Property(property="priority", type="string", example="alta"),
     *                 @OA\Property(property="estimated_hours", type="number", format="float", example=5.5),
     *                 @OA\Property(property="actual_hours", type="number", format="float", example=3.0),
     *                 @OA\Property(property="due_date", type="string", example="2025-12-31"),
     *                 @OA\Property(property="project_id", type="integer", example=1),
     *                 @OA\Property(property="assigned_user_id", type="integer", example=2)
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Crear una tarea",
     *     tags={"Tareas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "status", "priority", "estimated_hours", "due_date", "project_id", "assigned_user_id"},
     *             @OA\Property(property="title", type="string", example="Corregir bug"),
     *             @OA\Property(property="description", type="string", example="Descripción del bug..."),
     *             @OA\Property(property="status", type="string", example="pendiente"),
     *             @OA\Property(property="priority", type="string", example="alta"),
     *             @OA\Property(property="estimated_hours", type="number", format="float", example=5.5),
     *             @OA\Property(property="due_date", type="string", example="2025-12-31"),
     *             @OA\Property(property="project_id", type="integer", example=1),
     *             @OA\Property(property="assigned_user_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Tarea creada"),
     *     @OA\Response(response=400, description="Solicitud inválida")
     * )
     */
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
    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Elimina una Tarea",
     *     tags={"Tareas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Tarea eliminada"),
     *     @OA\Response(response=404, description="Tarea no encontrada")
     * )
     */

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada exitosamente');
    }

    public function myTasks()
    {
        $user = auth()->user(); // Obtiene el usuario autenticado
        $tasks = Task::where('assigned_user_id', $user->id)->get(); // Obtiene las tareas asignadas a ese usuario

        return view('tasks.my-tasks', compact('tasks'));
    }

}
