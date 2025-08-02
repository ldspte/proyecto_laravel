@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Proyecto: {{ $project->name }}</h1>

    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Nombre del Proyecto</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $project->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="client_name">Nombre del Cliente</label>
            <input type="text" class="form-control" id="client_name" name="client_name" value="{{ old('client_name', $project->client_name) }}" required>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="start_date">Fecha de Inicio</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                           value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="end_date">Fecha de Fin</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" 
                           value="{{ old('end_date', $project->end_date->format('Y-m-d')) }}" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="budget">Presupuesto</label>
            <input type="number" step="0.01" class="form-control" id="budget" name="budget" 
                   value="{{ old('budget', $project->budget) }}" required>
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select class="form-control" id="status" name="status" required>
                <option value="planning" {{ old('status', $project->status) == 'planning' ? 'selected' : '' }}>Planificación</option>
                <option value="in_progress" {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completado</option>
                <option value="on_hold" {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }}>En Espera</option>
            </select>
        </div>

        <div class="form-group">
            <label for="team_id">Equipo Asignado</label>
            <select class="form-control" id="team_id" name="team_id" required>
                @foreach($teams as $teamOption)
                <option value="{{ $teamOption->id }}" 
                    {{ old('team_id', $project->team_id) == $teamOption->id ? 'selected' : '' }}>
                    {{ $teamOption->name }} (Líder: {{ $teamOption->leader->name }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Actualizar Proyecto</button>
            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection