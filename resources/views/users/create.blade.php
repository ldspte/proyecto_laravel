@extends('layouts.app')

@section('content')
    <h1>Crear Usuario</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="salary">Salario</label>
            <input type="number" step="0.01" class="form-control" name="salary" >
        </div>
        <div class="form-group">
            <label for="role_id">Rol</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="">Seleccionar Rol</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
        </div>
        <div class="form-group">
            <label for="hire_date">Fecha de Contratación</label>
            <input type="date" name="hire_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Crear Usuario</button>
    </form>
@endsection