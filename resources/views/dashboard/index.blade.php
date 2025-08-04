@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>

    <h2>Reporte de Productividad por Desarrollador</h2>
    <div>
        <!-- Mostrar datos de productividad -->
        @foreach($developerProductivity as $data)
            <p>{{ $data->user_name }}: {{ $data->hours_worked }} horas trabajadas</p>
        @endforeach
    </div>

    <h2>Reporte de Estado de Proyectos</h2>
    <div>
        <!-- Mostrar estado de proyectos -->
        @foreach($projectStatus as $project)
            <p>{{ $project->name }}: {{ $project->status }}</p>
        @endforeach
    </div>

    <h2>Reporte Financiero por Equipo</h2>
    <div>
        <!-- Mostrar datos financieros -->
        <p>Costo de personal: {{ $teamFinancial->team_cost }}</p>
        <p>Ingresos generados: {{ $teamFinancial->generated_income }}</p>
    </div>

    <h2>Reporte de Timeline de Proyectos</h2>
    <div>
        <!-- Mostrar timeline de proyectos -->
        @foreach($projectTimeline as $timeline)
            <p>{{ $timeline->month }}: {{ $timeline->projects_count }} proyectos</p>
        @endforeach
    </div>
</div>
@endsection
