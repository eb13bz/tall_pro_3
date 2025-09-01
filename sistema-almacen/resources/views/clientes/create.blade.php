@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Crear Nuevo Cliente</h1>
</div>

<form action="{{ route('clientes.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="nombre_completo" class="form-label">Nombre Completo:</label>
        <input type="text" name="nombre_completo" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="cedula_nit" class="form-label">Cédula/NIT:</label>
        <input type="text" name="cedula_nit" class="form-control">
    </div>
    <div class="mb-3">
        <label for="direccion" class="form-label">Dirección:</label>
        <input type="text" name="direccion" class="form-control">
    </div>
    <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="text" name="telefono" class="form-control">
    </div>
    <div class="mb-3">
        <label for="correo_electronico" class="form-label">Correo Electrónico:</label>
        <input type="email" name="correo_electronico" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Guardar Cliente</button>
    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver a la lista</a>
</form>
@endsection