@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Usuario: {{ $user->name }}</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="role_id">Rol</label>
            <select class="form-control" id="role_id" name="role_id" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" 
                        {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="salary">Salario</label>
            <input type="number" step="0.01" class="form-control" id="salary" name="salary" 
                   value="{{ old('salary', $user->salary) }}">
        </div>
        <div class="form-group">
            <label for="hire_date">Fecha de Contratación</label>
            <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', $user->hire_date) }}" required>
        </div>

        <div class="form-group">
            <label for="password">Nueva Contraseña (dejar en blanco para no cambiar)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            <a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection