@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Crear Nuevo Usuario</h1>
</div>

<form action="{{ route('usuarios.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="nombre_completo" class="form-label">Nombre Completo:</label>
        <input type="text" name="nombre_completo" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="nombre_de_usuario" class="form-label">Nombre de Usuario:</label>
        <input type="text" name="nombre_de_usuario" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico:</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Contraseña:</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="text" name="telefono" class="form-control">
    </div>
    <div class="mb-3">
        <label for="rol_asignado" class="form-label">Rol:</label>
        <select name="rol_asignado" class="form-select" required>
            <option value="Administrador">Administrador</option>
            <option value="Vendedor">Vendedor</option>
            <option value="Almacenero">Almacenero</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Crear Usuario</button>
    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver a la lista</a>
</form>
@endsection