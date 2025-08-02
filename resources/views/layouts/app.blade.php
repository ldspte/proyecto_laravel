<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proyectos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Gestión de Proyectos</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('tasks.index') }}">Tareas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('projects.index') }}">Proyectos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('teams.index') }}">Equipos</a></li>
                </ul>
            </div>
        </nav>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>