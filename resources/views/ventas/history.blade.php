@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Historial de Ventas</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('ventas.index') }}" class="btn btn-sm btn-primary">Registrar Nueva Venta</a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->cliente ? $venta->cliente->nombre_completo : 'N/A' }}</td>
                    <td>{{ $venta->user->nombre_completo }}</td>
                    <td>{{ $venta->total }}</td>
                    <td><span class="badge {{ $venta->estado == 'anulada' ? 'bg-danger' : 'bg-success' }}">{{ $venta->estado }}</span></td>
                    <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                        @if ($venta->estado === 'completada' && Auth::user()->rol_asignado === 'Administrador')
                            <form action="{{ route('ventas.anular', $venta->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('¿Estás seguro de que quieres anular esta venta?')">Anular</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection