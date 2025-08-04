<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task; // Asegúrate de importar los modelos necesarios
use App\Models\Project;
use App\Models\User;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function index()
    {
        // Obtener datos de los reportes
        $developerProductivity = $this->developerProductivity();
        $projectStatus = $this->projectStatus();
        $teamFinancial = $this->teamFinancial();
        $projectTimeline = $this->projectTimeline();
        return view('dashboard.index', compact('developerProductivity', 'projectStatus', 'teamFinancial', 'projectTimeline'));
    }
    // a) Reporte de Productividad por Desarrollador
    public function developerProductivity()
    {
        $tasks = Task::all();
        $productivityData = [];
    
        foreach ($tasks as $task) {
            $userId = $task->assigned_user_id;
            $user = User::find($userId);
            
            if ($user) { // Verifica si el usuario existe
                if (!isset($productivityData[$userId])) {
                    $productivityData[$userId] = [
                        'user_name' => $user->name,
                        'hours_worked' => 0,
                        'completed_tasks' => 0,
                        'projects_participated' => 0,
                        'efficiency' => 0,
                        'average_hours_per_task' => 0,
                    ];
                }
            
                $productivityData[$userId]['hours_worked'] += $task->horas_actuales;
            
                if ($task->estado === 'completada') {
                    $productivityData[$userId]['completed_tasks'] += 1;
                }
            }
        }
    
        return $productivityData;
    }


    
    public function projectStatus()
    {
        $projects = Project::with('tasks')->get();

        foreach ($projects as $project) {
            $totalTasks = $project->tasks->count();
            $completedTasks = $project->tasks->where('estado', 'completada')->count();
            $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            $usedBudget = $project->tasks->sum('costo'); 
            $project->used_budget = $usedBudget;
            $remaining_budget = $project->total_budget - $usedBudget;

            $task_counts = [
                'completadas' => $project->tasks->where('estado', 'completada')->count(),
                'pendientes' => $project->tasks->where('estado', 'pendiente')->count(),
                'en_progreso' => $project->tasks->where('estado', 'en progreso')->count(),
            ];

            // $delayedProjects = Project::where('fecha_fin', '<', now())
            //     ->where('estado', '!=', 'completado')
            //     ->get();

            $projectsData[] = [
            'name' => $project->name,
            'projects' => $progress,
            'budget_used' => $remaining_budget,
            'tasks_by_status' => $task_counts,
            // 'assigned_developers' => $assignedDevelopers,
            // 'delayed_projects' => $delayedProjects,
        ];
        }
        return $projectsData;
    }

    public function teamFinancial()
    {
        $teams = Team::with('members')->get(); 
        foreach ($teams as $team) {
            $total_salary = $team->members->sum('salary');
            $generatedIncome = 0;
            $teamsData[] = [
                'name' => $team->name,
                'team_cost' => $total_salary,
                'generated_income' => $generatedIncome,
            ];
        }
        return $teamsData;
    }


    public function projectTimeline()
    {
        $year = $year ?? date('Y');


        // 1. Proyectos agrupados por mes de inicio
        $projectsByMonth = Project::selectRaw('MONTH(start_date) as month, COUNT(*) as count')
            ->whereYear('start_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                $item->month_name = Carbon::create()->month($item->month)->format('F');
                return $item;
            });
        // 2. Duración promedio por proyecto (en días)
        $averageDuration = Project::whereYear('start_date', $year)
            ->whereNotNull('end_date')
            ->selectRaw('AVG(DATEDIFF(end_date, start_date)) as avg_duration')
            ->value('avg_duration');
        // 3. Tasa de éxito (proyectos completados vs total)
        $totalProjects = Project::whereYear('start_date', $year)->count();
        $completedProjects = Project::whereYear('start_date', $year)
            ->where('status', 'completed')
            ->count();
        $successRate = $totalProjects > 0 ? round(($completedProjects / $totalProjects) * 100, 2) : 0;
        
        $workloadByMonth = DB::table('tasks')
            ->selectRaw('MONTH(due_date) as month, SUM(actual_hours) as total_hours')
            ->whereYear('due_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                $item->month_name = Carbon::create()->month($item->month)->format('F');
                return $item;
        });

        return response()->json([
            'projects_by_month' => $projectsByMonth,
            'average_duration' => $averageDuration,
            'success_rate' => $successRate,
            'monthly_workload_analysis' => $workloadByMonth,
        ]);
    }
}
