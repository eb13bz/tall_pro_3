<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    /**
     * Muestra la página de inicio de ventas.
     */
    public function index()
    {
        $productos = Producto::all();
        $clientes = Cliente::all();
        return view('ventas.index', compact('productos', 'clientes'));
    }

    /**
     * Procesa y almacena una nueva venta en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'descuento' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $detallesVenta = [];

            foreach ($request->productos as $item) {
                $producto = Producto::find($item['id']);

                if ($producto->stock_actual < $item['cantidad']) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'No hay suficiente stock para el producto: ' . $producto->nombre);
                }

                $precio_unitario = $producto->precio_unitario;
                $subtotal_item = $precio_unitario * $item['cantidad'];
                $subtotal += $subtotal_item;

                $detallesVenta[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $precio_unitario,
                    'subtotal_item' => $subtotal_item,
                ];

                // Reducir stock del producto
                $producto->stock_actual -= $item['cantidad'];
                $producto->save();
            }

            $descuentos = $request->descuento ?? 0;
            $total = $subtotal - $descuentos;

            // Crear la venta
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'user_id' => Auth::id(), // Usuario que registra la venta
                'subtotal' => $subtotal,
                'descuentos' => $descuentos,
                'total' => $total,
            ]);

            // Almacenar los detalles de la venta
            foreach ($detallesVenta as $detalle) {
                $venta->detalles()->create($detalle);
            }

            DB::commit();

            return redirect()->route('ventas.show', $venta->id)->with('success', 'Venta registrada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Hubo un problema al registrar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Muestra los detalles de una venta específica.
     */
    public function show(Venta $venta)
    {
        $venta->load('cliente', 'user', 'detalles.producto');
        return view('ventas.show', compact('venta'));
    }

    /**
     * Muestra el historial de ventas.
     */
    public function history()
    {
        $ventas = Venta::with(['cliente', 'user'])->latest()->get();
        return view('ventas.history', compact('ventas'));
    }

    /**
     * Anula una venta. Solo para administradores.
     */
    public function anular(Venta $venta)
    {
        // Lógica de validación para rol de administrador
        if (Auth::user()->rol_asignado !== 'Administrador') {
            return redirect()->back()->with('error', 'No tienes permiso para anular ventas.');
        }

        try {
            DB::beginTransaction();

            // Revertir el stock de los productos
            foreach ($venta->detalles as $detalle) {
                $producto = Producto::find($detalle->producto_id);
                if ($producto) {
                    $producto->stock_actual += $detalle->cantidad;
                    $producto->save();
                }
            }

            // Cambiar el estado de la venta a "anulada"
            $venta->update(['estado' => 'anulada']);

            DB::commit();

            return redirect()->route('ventas.history')->with('success', 'Venta anulada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Hubo un problema al anular la venta.');
        }
    }
}
