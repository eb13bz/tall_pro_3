@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Módulo de Reportes y Consultas</h1>
</div>
<p>Seleccione el tipo de reporte que desea generar.</p>
<div class="list-group">
    <a href="{{ route('reportes.ventas') }}" class="list-group-item list-group-item-action">Reporte de Ventas por Período</a>
    <a href="{{ route('reportes.stockBajo') }}" class="list-group-item list-group-item-action">Reporte de Stock Bajo</a>
    <a href="{{ route('reportes.clientesFrecuentes') }}" class="list-group-item list-group-item-action">Reporte de Clientes Frecuentes</a>
</div>
@endsection