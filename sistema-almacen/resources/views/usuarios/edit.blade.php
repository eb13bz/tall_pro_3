@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Usuario</h1>
</div>

@if ($user)
    <form action="{{ route('usuarios.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre_completo" class="form-label">Nombre Completo:</label>
            <input type="text" name="nombre_completo" class="form-control" value="{{ $user->nombre_completo }}" required>
        </div>
        <div class="mb-3">
            <label for="nombre_de_usuario" class="form-label">Nombre de Usuario:</label>
            <input type="text" name="nombre_de_usuario" class="form-control" value="{{ $user->nombre_de_usuario }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico:</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" name="telefono" class="form-control" value="{{ $user->telefono }}">
        </div>
        <div class="mb-3">
            <label for="rol_asignado" class="form-label">Rol:</label>
            <select name="rol_asignado" class="form-select" required>
                <option value="Administrador" {{ $user->rol_asignado == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                <option value="Vendedor" {{ $user->rol_asignado == 'Vendedor' ? 'selected' : '' }}>Vendedor</option>
                <option value="Almacenero" {{ $user->rol_asignado == 'Almacenero' ? 'selected' : '' }}>Almacenero</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </form>
@else
    <div class="alert alert-danger">
        El usuario no fue encontrado.
    </div>
@endif
@endsection