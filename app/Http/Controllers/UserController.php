<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index()
    {
        $users = User::all();
        return view('usuarios.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'nombre_de_usuario' => 'required|string|unique:users,nombre_de_usuario|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:8',
            'telefono' => 'nullable|string|max:20',
            'rol_asignado' => ['required', Rule::in(['Administrador', 'Vendedor', 'Almacenero'])],
        ]);

        User::create([
            'name' => $request->nombre_completo,
            'nombre_completo' => $request->nombre_completo,
            'nombre_de_usuario' => $request->nombre_de_usuario,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rol_asignado' => $request->rol_asignado,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

   /**
 * Muestra el formulario para editar un usuario existente.
 */
public function edit($id) // <-- Cambiado a recibir solo el ID
{
    $user = User::findOrFail($id); // <-- Busca el usuario de forma explícita
    return view('usuarios.edit', compact('user'));
}

    /**
     * Actualiza un usuario en la base de datos.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'nombre_de_usuario' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'telefono' => 'nullable|string|max:20',
            'rol_asignado' => ['required', Rule::in(['Administrador', 'Vendedor', 'Almacenero'])],
        ]);

        $user->update([
            'name' => $request->nombre_completo,
            'nombre_completo' => $request->nombre_completo,
            'nombre_de_usuario' => $request->nombre_de_usuario,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'rol_asignado' => $request->rol_asignado,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}