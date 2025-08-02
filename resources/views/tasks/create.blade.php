@extends('layouts.app')

@section('content')
    <h1>Crear Tarea</h1>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Nombre</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="due_date">Fecha de Vencimiento</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" class="form-control" required>
                <option value="pendiente">Pendiente</option>
                <option value="en_progreso">En Progreso</option>
                <option value="completada">Completada</option>
            </select>
        </div>
        <div class="form-group">
            <label for="project_id">Proyecto</label>
            <select name="project_id" class="form-control" required>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="assigned_user_id">Usuario Asignado</label>
            <select name="assigned_user_id" class="form-control" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Crear Tarea</button>
    </form>
@endsection