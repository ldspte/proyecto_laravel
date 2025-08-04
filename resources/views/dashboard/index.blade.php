@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>

    <h2>Reporte de Productividad por Desarrollador</h2>
    <div>
        <!-- Mostrar datos de productividad -->
        @foreach($developerProductivity as $data)
            <p>{{ $data['user_name'] }}: {{ $data['hours_worked'] }} horas trabajadas</p> <!-- Acceso a propiedades como array -->
        @endforeach
    </div>

    <h2>Reporte de Estado de Proyectos</h2>
    <div>
        <!-- Mostrar estado de proyectos -->
        @foreach($projectStatus as $project)
            <p>{{ $project['name'] }}: {{ $project['projects'] }}% completado, Presupuesto restante: {{ $project['budget_used'] }}</p> <!-- Acceso a propiedades como array -->
        @endforeach
    </div>

    <h2>Reporte Financiero por Equipo</h2>
    <div>
        <!-- Mostrar datos financieros -->
        @foreach($teamFinancial as $team)
            <p>Equipo: {{ $team['name'] }}</p>
            <p>Costo de personal: {{ $team['team_cost'] }}</p>
            <p>Ingresos generados: {{ $team['generated_income'] }}</p>
        @endforeach
    </div>

    <h2>Reporte de Timeline de Proyectos</h2>
    <div>
        
    </div>
</div>
@endsection