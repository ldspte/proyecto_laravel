@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Detalles de la Tarea: {{ $task->name }}</h1>
            
            <div class="card mb-4">
                <div class="card-header">Información de la Tarea</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nombre:</strong> {{ $task->name }}</li>
                        <li class="list-group-item"><strong>Descripción:</strong> {{ $task->description }}</li>
                        <li class="list-group-item"><strong>Estado:</strong>
                            <span class="badge 
                                @if($task->status == 'pendiente') badge-secondary
                                @elseif($task->status == 'en_progreso') badge-primary
                                @elseif($task->status == 'completada') badge-success
                                @endif">
                                {{ ucfirst($task->status) }}
                            </span>
                        </li>
                        <li class="list-group-item"><strong>Fecha Límite:</strong> {{ $task->due_date->format('d/m/Y') }}</li>
                        <li class="list-group-item"><strong>Prioridad:</strong> {{ ucfirst($task->priority) }}</li>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Detalles de Prioridad</h5>
                                <p><strong>Prioridad:</strong> 
                                    <span class="{{ $priorityClasses[$task->priority] }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </p>
                                <p><strong>Horas Estimadas:</strong> {{ $task->estimated_hours ?? 'No especificado' }}</p>
                            </div>
                        </div>
                        <li class="list-group-item">
                            <strong>Asignado a:</strong> 
                            <a href="{{ route('users.show', $task->assigned_user_id) }}">
                                {{ $task->assignedUser->name }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Información del Proyecto</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Proyecto:</strong>
                            <a href="{{ route('projects.show', $task->project_id) }}">
                                {{ $task->project->name }}
                            </a>
                        </li>
                        <li class="list-group-item"><strong>Cliente:</strong> {{ $task->project->client_name }}</li>
                        <li class="list-group-item"><strong>Estado del Proyecto:</strong>
                            <span class="badge 
                                @if($task->project->status == 'planning') badge-secondary
                                @elseif($task->project->status == 'in_progress') badge-primary
                                @elseif($task->project->status == 'completed') badge-success
                                @elseif($task->project->status == 'on_hold') badge-warning
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $task->project->status)) }}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <strong>Equipo:</strong>
                            <a href="{{ route('teams.show', $task->project->team_id) }}">
                                {{ $task->project->team->name }}
                            </a> (Líder: {{ $task->project->team->leader->name }})
                        </li>
                    </ul>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Editar Tarea</a>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar Tarea</button>
                </form>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Volver al listado</a>
            </div>
        </div>
    </div>
</div>
@endsection