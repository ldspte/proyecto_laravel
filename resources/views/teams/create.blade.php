@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Crear Nuevo Equipo</h1>

    <form action="{{ route('teams.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Nombre del Equipo</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="team_leader_id">Líder del Equipo</label>
            <select class="form-control" id="team_leader_id" name="team_leader_id" required>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="member_ids">Miembros del Equipo</label>
            <select multiple class="form-control" id="member_ids" name="member_ids[]" size="5">
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Mantén presionado Ctrl (Windows) o Command (Mac) para seleccionar múltiples miembros.</small>
        </div>

        <div class="form-group">
            <label for="budget">Presupuesto</label>
            <input type="number" step="0.01" class="form-control" name="budget" >
        </div>

        <button type="submit" class="btn btn-primary">Guardar Equipo</button>
    </form>
</div>
@endsection