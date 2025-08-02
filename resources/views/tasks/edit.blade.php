@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Tarea: {{ $task->name }}</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Nombre de la Tarea</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ old('name', $task->name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="due_date">Fecha Límite</label>
            <input type="date" class="form-control" id="due_date" name="due_date" 
                   value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select class="form-control" id="status" name="status" required>
                <option value="pendiente" {{ old('status', $task->status) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en_progreso" {{ old('status', $task->status) == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                <option value="completada" {{ old('status', $task->status) == 'completada' ? 'selected' : '' }}>Completada</option>
            </select>
        </div>

        <div class="form-group">
            <label for="project_id">Proyecto</label>
            <select class="form-control" id="project_id" name="project_id" required>
                @foreach($projects as $project)
                <option value="{{ $project->id }}" 
                    {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                    {{ $project->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="assigned_user_id">Asignado a</label>
            <select class="form-control" id="assigned_user_id" name="assigned_user_id" required>
                @foreach($users as $user)
                <option value="{{ $user->id }}" 
                    {{ old('assigned_user_id', $task->assigned_user_id) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection