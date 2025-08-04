
@extends('layouts.app')

@section('content')
    <h1>Tareas</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Crear Tarea</a>
    <table class="table">
        <thead>
            <tr>
                <th>Titulo</th>
                <th>Descripción</th>
                <th>Fecha de Vencimiento</th>
                <th>Estado</th>
                <th>Prioridad</th>
                <th>Horas Estimadas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ $task->status }}</td>
                    <td>
                        @php
                            $priorityClasses = [
                                'baja' => 'badge badge-secondary',
                                'media' => 'badge badge-primary',
                                'alta' => 'badge badge-warning',
                                'critica' => 'badge badge-danger'
                            ];
                        @endphp
                        <span class="{{ $priorityClasses[$task->priority] }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </td>
                    <td>{{ $task->estimated_hours ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection