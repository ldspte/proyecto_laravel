@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $team->name }}</h1>
            @if($team->description)
            <p class="lead">{{ $team->description }}</p>
            @endif
            
            <div class="card mb-4">
                <div class="card-header">Información del Equipo</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Líder del Equipo:</strong> 
                            <a href="#">{{ $team->leader->name }}</a>
                        </li>
                        <li class="list-group-item">
                            <strong>Total de Miembros:</strong> {{ $team->members->count() }}
                        </li>
                        <li class="list-group-item">
                            <strong>Total de Proyectos:</strong> {{ $team->projects->count() }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Miembros del Equipo</div>
                <div class="card-body">
                    <div class="row">
                        @foreach($team->members as $member)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $member->name }}</h5>
                                    <p class="card-text">{{ $member->email }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Proyectos del Equipo</div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($team->projects as $project)
                        <a href="{{ route('projects.show', $project->id) }}" class="list-group-item list-group-item-action">
                            {{ $project->name }} - 
                            <span class="badge 
                                @if($project->status == 'planning') badge-secondary
                                @elseif($project->status == 'in_progress') badge-primary
                                @elseif($project->status == 'completed') badge-success
                                @elseif($project->status == 'on_hold') badge-warning
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection