@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Categoría</h1>
</div>

<form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" name="nombre" class="form-control" value="{{ $categoria->nombre }}" required>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción:</label>
        <textarea name="descripcion" class="form-control">{{ $categoria->descripcion }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Volver a la lista</a>
</form>
@endsection