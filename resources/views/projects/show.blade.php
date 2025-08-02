@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $project->name }}</h1>
            <p class="lead">{{ $project->description }}</p>
            
            <div class="card mb-4">
                <div class="card-header">Detalles del Proyecto</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Cliente:</strong> {{ $project->client_name }}</li>
                        <li class="list-group-item"><strong>Fecha Inicio:</strong> {{ $project->start_date->format('d/m/Y') }}</li>
                        <li class="list-group-item"><strong>Fecha Fin:</strong> {{ $project->end_date->format('d/m/Y') }}</li>
                        <li class="list-group-item"><strong>Presupuesto:</strong> ${{ number_format($project->budget, 2) }}</li>
                        <li class="list-group-item">
                            <strong>Estado:</strong>
                            <span class="badge 
                                @if($project->status == 'planning') badge-secondary
                                @elseif($project->status == 'in_progress') badge-primary
                                @elseif($project->status == 'completed') badge-success
                                @elseif($project->status == 'on_hold') badge-warning
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <strong>Equipo:</strong> 
                            <a href="{{ route('teams.show', $project->team_id) }}">{{ $project->team->name }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Tareas del Proyecto</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tarea</th>
                                <th>Asignado a</th>
                                <th>Fecha Límite</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->tasks as $task)
                            <tr>
                                <td>{{ $task->name }}</td>
                                <td>{{ $task->assignedUser->name }}</td>
                                <td>{{ $task->due_date->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge 
                                        @if($task->status == 'pendiente') badge-secondary
                                        @elseif($task->status == 'en_progreso') badge-primary
                                        @elseif($task->status == 'completada') badge-success
                                        @endif">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-info">Ver</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection