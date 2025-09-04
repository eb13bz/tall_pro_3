@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detalle de Venta #{{ $venta->id }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('ventas.history') }}" class="btn btn-sm btn-secondary">Volver al Historial</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                Información General
            </div>
            <div class="card-body">
                <p><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Vendedor:</strong> {{ $venta->user->nombre_completo }}</p>
                <p><strong>Cliente:</strong> {{ $venta->cliente ? $venta->cliente->nombre_completo : 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>

<h3>Productos Vendidos</h3>
<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($venta->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ $detalle->precio_unitario }}</td>
                    <td>{{ $detalle->subtotal_item }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<h3>Resumen de la Venta</h3>
<div class="card p-3">
    <p>Subtotal: {{ $venta->subtotal }}</p>
    <p>Descuentos: {{ $venta->descuentos }}</p>
    <p class="fw-bold">Total: {{ $venta->total }}</p>
    <p class="fw-bold">Estado: <span class="badge {{ $venta->estado == 'anulada' ? 'bg-danger' : 'bg-success' }}">{{ $venta->estado }}</span></p>
</div>
@endsection