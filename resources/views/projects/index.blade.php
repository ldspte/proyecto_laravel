@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Listado de Proyectos</h1>
    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Crear Nuevo Proyecto</a>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Cliente</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->client_name }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date}}</td>
                    <td>
                        <span class="badge 
                            @if($project->status == 'planning') badge-secondary
                            @elseif($project->status == 'in_progress') badge-primary
                            @elseif($project->status == 'completed') badge-success
                            @elseif($project->status == 'on_hold') badge-warning
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
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