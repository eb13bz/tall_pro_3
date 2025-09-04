<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Muestra el dashboard con información resumida.
     */
    public function index()
    {
        // Obtener el total de productos
        $totalProductos = Producto::count();

        // Obtener el total de clientes
        $totalClientes = Cliente::count();

        // Obtener el total de productos con stock bajo (ejemplo: stock < 5)
        $productosBajoStock = Producto::where('stock_actual', '<', 5)->count();

        // Obtener las ventas del día actual
        $ventasHoy = Venta::whereDate('created_at', Carbon::today())->count();

        return view('home', compact('totalProductos', 'totalClientes', 'productosBajoStock', 'ventasHoy'));
    }
}