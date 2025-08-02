@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Listado de Equipos</h1>
    <a href="{{ route('teams.create') }}" class="btn btn-primary mb-3">Crear Nuevo Equipo</a>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Líder</th>
                    <th>Miembros</th>
                    <th>Proyectos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $team)
                <tr>
                    <td>{{ $team->name }}</td>
                    <td>{{ $team->leader->name }}</td>
                    <td>{{ $team->members->count() }}</td>
                    <td>{{ $team->projects->count() }}</td>
                    <td>
                        <a href="{{ route('teams.show', $team->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('teams.destroy', $team->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection