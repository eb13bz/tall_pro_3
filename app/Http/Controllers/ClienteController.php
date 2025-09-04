<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

  
    public function create()
    {
        return view('clientes.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'cedula_nit' => 'nullable|string|unique:clientes,cedula_nit|max:50',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo_electronico' => 'nullable|string|email|unique:clientes,correo_electronico|max:255',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }


    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

 
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'cedula_nit' => [
                'nullable',
                'string',
                Rule::unique('clientes', 'cedula_nit')->ignore($cliente->id),
            ],
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo_electronico' => [
                'nullable',
                'string',
                'email',
                Rule::unique('clientes', 'correo_electronico')->ignore($cliente->id),
            ],
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
    }
}
