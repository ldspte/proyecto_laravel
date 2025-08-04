<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task; // Asegúrate de importar los modelos necesarios
use App\Models\Project;
use App\Models\User;
use App\Models\Team;

class ReportController extends Controller
{

    public function index()
    {
        // Obtener datos de los reportes
        $developerProductivity = $this->developerProductivity();
        $projectStatus = $this->projectStatus();
        $teamFinancial = $this->teamFinancial();
        $projectTimeline = $this->projectTimeline();
        return view('dashboard', compact('developerProductivity', 'projectStatus', 'teamFinancial', 'projectTimeline'));
    }
    // a) Reporte de Productividad por Desarrollador
    public function developerProductivity(Request $request)
    {
        
        $tasks = Task::all();
        $projects = Project::all();

        $productivityData = [];

        foreach ($tasks as $task) {
            $userId = $task->assigned_user_id; // Asegúrate de que tienes el campo user_id en la tabla tasks
            if (!isset($productivityData[$userId])) {
                $productivityData[$userId] = [
                    'user_name' => $task->assigned_user_id->name, // Asegúrate de tener la relación definida en el modelo User
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

        return $productivityData;
    }

    
    public function projectStatus(Request $request)
    {
        $teamId = $request->input('team_id');
        $status = $request->input('status');

       

        return response()->json([
            'projects' => $projects,
            'budget_used' => $budgetUsed,
            'tasks_by_status' => $tasksByStatus,
            'assigned_developers' => $assignedDevelopers,
            'delayed_projects' => $delayedProjects,
        ]);
    }

    public function teamFinancial()
    {
        

        return response()->json([
            'team_cost' => $teamCost,
            'generated_income' => $generatedIncome,
        ]);
    }


    public function projectTimeline(Request $request)
    {
        $year = $request->input('year', date('Y'));


        return response()->json([
            'projects_by_month' => $projectsByMonth,
            'average_duration' => $averageDuration,
            'success_rate' => $successRate,
            'monthly_workload_analysis' => $monthlyWorkloadAnalysis,
        ]);
    }
}
