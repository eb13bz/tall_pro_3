<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación de los campos de login (nombre de usuario y contraseña)
        $request->validate([
            'nombre_de_usuario' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Intentar autenticar al usuario usando el nombre_de_usuario
        if (Auth::attempt(['nombre_de_usuario' => $request->nombre_de_usuario, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Redirigir a la página principal después de iniciar sesión
            return redirect()->intended('/');
        }

        // Si la autenticación falla, redirigir de nuevo al formulario de login con un error
        return back()->withErrors([
            'nombre_de_usuario' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('nombre_de_usuario');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}