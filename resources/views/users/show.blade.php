@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Detalles del Usuario: {{ $user->name }}</h1>
            
            <div class="card mb-4">
                <div class="card-header">Información Básica</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nombre:</strong> {{ $user->name }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                        <li class="list-group-item">
                            <strong>Rol:</strong>
                            <span class="badge badge-primary">
                                {{ $user->role->name }}
                            </span>
                        </li>
                        <li class="list-group-item"><strong>Fecha de creación:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Equipos que Lidera</div>
                <div class="card-body">
                    @if($user->ledTeams->count() > 0)
                        <div class="list-group">
                            @foreach($user->ledTeams as $team)
                            <a href="{{ route('teams.show', $team->id) }}" class="list-group-item list-group-item-action">
                                {{ $team->name }} ({{ $team->members->count() }} miembros)
                            </a>
                            @endforeach
                        </div>
                    @else
                        <p>Este usuario no lidera ningún equipo actualmente.</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">Tareas Asignadas</div>
                <div class="card-body">
                    @if($user->assignedTasks->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tarea</th>
                                    <th>Proyecto</th>
                                    <th>Fecha Límite</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->assignedTasks as $task)
                                <tr>
                                    <td><a href="{{ route('tasks.show', $task->id) }}">{{ $task->name }}</a></td>
                                    <td><a href="{{ route('projects.show', $task->project_id) }}">{{ $task->project->name }}</a></td>
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Este usuario no tiene tareas asignadas actualmente.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection