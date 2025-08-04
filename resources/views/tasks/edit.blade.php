@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Tarea: {{ $task->name }}</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Nombre de la Tarea</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ old('title', $task->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="due_date">Fecha Límite</label>
            <input type="date" class="form-control" id="due_date" name="due_date" 
                   value="{{ old('due_date', $task->due_date) }}" required>
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
            <label for="priority">Prioridad</label>
            <select class="form-control" id="priority" name="priority" required>
                <option value="baja" {{ old('priority', $task->priority ?? '') == 'baja' ? 'selected' : '' }}>Baja</option>
                <option value="media" {{ old('priority', $task->priority ?? 'media') == 'media' ? 'selected' : '' }}>Media</option>
                <option value="alta" {{ old('priority', $task->priority ?? '') == 'alta' ? 'selected' : '' }}>Alta</option>
                <option value="critica" {{ old('priority', $task->priority ?? '') == 'critica' ? 'selected' : '' }}>Crítica</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="estimated_hours">Horas Estimadas</label>
            <input type="number" step="0.25" class="form-control" id="estimated_hours" 
                   name="estimated_hours" value="{{ old('estimated_hours', $task->estimated_hours ?? '') }}"
                   min="0.25" max="100">
            <small class="form-text text-muted">Puedes usar valores como 1.5, 2.25, etc.</small>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection