@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mis Tareas</h1>
    
    @if($tasks->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Horas Estimadas</th>
                        <th>Horas Actuales</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>
                            <span class="badge 
                                @if($task->status === 'pendiente') badge-secondary
                                @elseif($task->status === 'en progreso') badge-primary
                                @else badge-success @endif">
                                {{ $task->status }}
                            </span>
                        </td>
                        <td>{{ $task->estimated_hours }}h</td>
                        <td>{{ $task->actual_hours }}h</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">No tienes tareas asignadas.</div>
    @endif
</div>
@endsection