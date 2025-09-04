<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Muestra el menú principal del módulo de reportes.
     */
    public function index()
    {
        return view('reportes.index');
    }

    /**
     * Reporte de Ventas con filtro de búsqueda.
     */
    public function reporteVentas(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'busqueda' => 'nullable|string',
        ]);

        $fechaInicio = $request->fecha_inicio ? Carbon::parse($request->fecha_inicio)->startOfDay() : null;
        $fechaFin = $request->fecha_fin ? Carbon::parse($request->fecha_fin)->endOfDay() : null;
        $busqueda = $request->busqueda;

        $query = Venta::query();

        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }

        if ($busqueda) {
            $query->whereHas('cliente', function ($q) use ($busqueda) {
                $q->where('nombre_completo', 'like', '%' . $busqueda . '%');
            })->orWhereHas('detalles.producto', function ($q) use ($busqueda) {
                $q->where('nombre', 'like', '%' . $busqueda . '%');
            });
        }

        $ventas = $query->latest()->get();
        $totalVentas = $ventas->sum('total');

        return view('reportes.ventas', compact('ventas', 'totalVentas', 'fechaInicio', 'fechaFin', 'busqueda'));
    }

    /**
     * Reporte de Stock Bajo.
     */
    public function reporteStockBajo()
    {
        $productos = Producto::where('stock_actual', '<', 5)->get();
        return view('reportes.stock-bajo', compact('productos'));
    }

    /**
     * Reporte de Clientes Frecuentes.
     */
    public function reporteClientesFrecuentes()
    {
        $clientes = Cliente::withCount('ventas')
                            ->orderByDesc('ventas_count')
                            ->get();
        return view('reportes.clientes-frecuentes', compact('clientes'));
    }
}
