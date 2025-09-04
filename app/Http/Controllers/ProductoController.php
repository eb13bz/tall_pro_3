<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
     public function index()
    {
        $productos = Producto::with('categoria')->get();
        return view('productos.index', compact('productos'));
    }

 
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'codigo_unico' => 'required|string|unique:productos,codigo_unico',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_unitario' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'unidad_medida' => 'required|string|max:50',
            'proveedor' => 'nullable|string|max:255',
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }


    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

  
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'codigo_unico' => [
                'required',
                'string',
                Rule::unique('productos', 'codigo_unico')->ignore($producto->id),
            ],
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_unitario' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'unidad_medida' => 'required|string|max:50',
            'proveedor' => 'nullable|string|max:255',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

  
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}