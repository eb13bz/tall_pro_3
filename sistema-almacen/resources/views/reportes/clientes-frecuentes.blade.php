@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Reporte de Clientes Frecuentes</h1>
</div>
<p>Listado de clientes ordenados por la cantidad de ventas registradas.</p>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Total de Ventas</th>
                <th>Teléfono</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nombre_completo }}</td>
                    <td><span class="badge bg-info">{{ $cliente->ventas_count }}</span></td>
                    <td>{{ $cliente->telefono ?? 'N/A' }}</td>
                    <td>{{ $cliente->correo_electronico ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection