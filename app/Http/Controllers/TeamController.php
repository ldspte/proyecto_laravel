<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Equipos",
 *     description="Operaciones relacionadas con equipos"
 * )
 */

class TeamController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/teams",
     *     summary="Obtener lista de equipos",
     *     tags={"Equipos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de equipos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Equipo Alpha"),
     *                 @OA\Property(property="description", type="string", example="Equipo de desarrollo backend"),
     *                 @OA\Property(property="budget", type="string", example="50000")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $teams = Team::with(['leader', 'members', 'projects'])->get();
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        $users = User::all();
        return view('teams.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'team_leader_id' => 'required|exists:users,id',
            'budget' => 'required|string'
        ]);

        DB::transaction(function () use ($validated, $request) {
        $team = Team::create($validated);
        
            if ($request->has('member_ids')) {
                $team->members()->attach($request->member_ids, [
                    'joined_at' => now()
                ]);
            }
        });

        return redirect()->route('teams.index')->with('success', 'Equipo creado exitosamente');
    }

    /**
     * @OA\Get(
     *     path="/api/teams/{id}",
     *     summary="Obtener información de un equipo",
     *     tags={"Equipos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del equipo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Datos del equipo"),
     *     @OA\Response(response=404, description="Equipo no encontrado")
     * )
     */

    public function show(Team $team)
    {
        $team->load(['leader', 'members', 'projects.tasks']);
        return view('teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        $users = User::all();
        return view('teams.edit', compact('team', 'users'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'team_leader_id' => 'required|exists:users,id',
            'budget' => 'required|string'
        ]);

        DB::transaction(function () use ($team, $validated, $request) {
            $team->update($validated);

            if ($request->has('member_ids')) {
                // Para nuevos miembros, establece joined_at
                $currentMembers = $team->members()->pluck('user_id')->toArray();
                $newMembers = array_diff($request->member_ids, $currentMembers);

                foreach ($newMembers as $memberId) {
                    $team->members()->attach($memberId, [
                        'joined_at' => now()
                    ]);
                }
            }
        });

        return redirect()->route('teams.index')->with('success', 'Equipo actualizado exitosamente');
    }
    /**
     * @OA\Delete(
     *     path="/api/teams/{id}",
     *     summary="Elimina un equipo",
     *     tags={"Equipos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Equipo eliminado"),
     *     @OA\Response(response=404, description="Equipo no encontrado")
     * )
     */


    public function destroy(Team $team)
    {
        DB::transaction(function () use ($team) {
            $team->members()->detach();
            $team->delete();
        });

        return redirect()->route('teams.index')->with('success', 'Equipo eliminado exitosamente');
    }

    public function addMembers(Request $request, Team $team)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);
    
        // Agrega nuevos miembros con la fecha actual
        $team->members()->attach($validated['user_ids'], [
            'joined_at' => now()
        ]);
    
        return back()->with('success', 'Miembros agregados al equipo correctamente');
    }

}
