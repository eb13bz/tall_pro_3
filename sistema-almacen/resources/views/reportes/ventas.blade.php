@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Reporte de Ventas</h1>
</div>

<div class="card mb-4">
    <div class="card-header">Filtros de Búsqueda</div>
    <div class="card-body">
        <form action="{{ route('reportes.ventas') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="busqueda" class="form-label">Buscar por cliente o producto:</label>
                    <input type="text" name="busqueda" id="busqueda" class="form-control" value="{{ request('busqueda') }}">
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="alert alert-info">
    <p><strong>Período:</strong> {{ $fechaInicio ? $fechaInicio->format('d/m/Y') : 'Todos' }} - {{ $fechaFin ? $fechaFin->format('d/m/Y') : 'Todos' }}</p>
    <p><strong>Búsqueda:</strong> {{ $busqueda ?? 'Ninguna' }}</p>
    <p class="fw-bold"><strong>Total de Ventas:</strong> {{ number_format($totalVentas, 2) }}</p>
</div>

<h3 class="mt-4">Listado de Ventas</h3>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->cliente->nombre_completo ?? 'N/A' }}</td>
                    <td>{{ $venta->user->nombre_completo ?? 'N/A' }}</td>
                    <td>{{ $venta->total }}</td>
                    <td><span class="badge {{ $venta->estado == 'anulada' ? 'bg-danger' : 'bg-success' }}">{{ $venta->estado }}</span></td>
                    <td>{{ $venta->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection