@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Equipo: {{ $team->name }}</h1>

    <form action="{{ route('teams.update', $team->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Nombre del Equipo</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ old('name', $team->name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $team->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="team_leader_id">Líder del Equipo</label>
            <select class="form-control" id="team_leader_id" name="team_leader_id" required>
                @foreach($users as $user)
                <option value="{{ $user->id }}" 
                    {{ old('team_leader_id', $team->team_leader_id) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="member_ids">Miembros del Equipo</label>
            <select multiple class="form-control" id="member_ids" name="member_ids[]" size="5">
                @foreach($users as $user)
                <option value="{{ $user->id }}" 
                    {{ in_array($user->id, old('member_ids', $team->members->pluck('id')->toArray())) ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Mantén presionado Ctrl (Windows) o Command (Mac) para seleccionar múltiples miembros.</small>
        </div>

        <div class="form-group">
            <label for="budget">Presupuesto</label>
            <input type="number" step="0.01" class="form-control" id="budget" name="budget" 
                   value="{{ old('budget', $team->budget) }}">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Actualizar Equipo</button>
            <a href="{{ route('teams.show', $team->id) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection