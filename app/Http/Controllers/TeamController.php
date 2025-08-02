<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
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
