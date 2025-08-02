@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Crear Nuevo Proyecto</h1>

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Nombre del Proyecto</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="client_name">Nombre del Cliente</label>
            <input type="text" class="form-control" id="client_name" name="client_name" required>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="start_date">Fecha de Inicio</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="end_date">Fecha de Fin</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="budget">Presupuesto</label>
            <input type="number" step="0.01" class="form-control" id="budget" name="budget" required>
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select class="form-control" id="status" name="status" required>
                <option value="planning">Planificación</option>
                <option value="in_progress">En Progreso</option>
                <option value="completed">Completado</option>
                <option value="on_hold">En Espera</option>
            </select>
        </div>

        <div class="form-group">
            <label for="team_id">Equipo Asignado</label>
            <select class="form-control" id="team_id" name="team_id" required>
                @foreach($teams as $team)
                <option value="{{ $team->id }}">{{ $team->name }} (Líder: {{ $team->leader->name }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Proyecto</button>
    </form>
</div>
@endsection