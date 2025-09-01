@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Producto</h1>
</div>

<form action="{{ route('productos.update', $producto->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="codigo_unico" class="form-label">Código Único:</label>
        <input type="text" name="codigo_unico" class="form-control" value="{{ $producto->codigo_unico }}" required>
    </div>
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción:</label>
        <textarea name="descripcion" class="form-control">{{ $producto->descripcion }}</textarea>
    </div>
    <div class="mb-3">
        <label for="categoria_id" class="form-label">Categoría:</label>
        <select name="categoria_id" class="form-select" required>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="precio_unitario" class="form-label">Precio Unitario:</label>
        <input type="number" name="precio_unitario" step="0.01" class="form-control" value="{{ $producto->precio_unitario }}" required>
    </div>
    <div class="mb-3">
        <label for="stock_actual" class="form-label">Stock Actual:</label>
        <input type="number" name="stock_actual" class="form-control" value="{{ $producto->stock_actual }}" required>
    </div>
    <div class="mb-3">
        <label for="unidad_medida" class="form-label">Unidad de Medida:</label>
        <input type="text" name="unidad_medida" class="form-control" value="{{ $producto->unidad_medida }}" required>
    </div>
    <div class="mb-3">
        <label for="proveedor" class="form-label">Proveedor:</label>
        <input type="text" name="proveedor" class="form-control" value="{{ $producto->proveedor }}">
    </div>
    <button type="submit" class="btn btn-primary">Actualizar Producto</button>
    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver a la lista</a>
</form>
@endsection