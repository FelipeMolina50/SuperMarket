<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            // Verificar si el correo ha sido verificado
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Por favor verifica tu correo electrónico antes de ingresar. Te enviamos un enlace al registrarte.',
                ])->onlyInput('email');
            }

            // Verificar si la cuenta ha sido aprobada
            if(Auth::user()->status !== 'approved') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tu cuenta aún no ha sido aprobada por el administrador.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'terms' => ['accepted']
        ], [
            'name.required' => 'El nombre completo es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'email.unique' => 'Este correo ya se encuentra registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'terms.accepted' => 'Debe aceptar los términos y condiciones.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'pending' // Por defecto pendiente
        ]);

        event(new Registered($user));

        return redirect('/login')->with('status', 'Registro exitoso. Te hemos enviado un enlace de verificación a tu correo.');
    }

    public function verifyEmail(Request $request, $id, $hash) {
        $user = User::findOrFail($id);
        
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/login')->with('status', 'Tu correo ya estaba verificado.');
        }

        $user->markEmailAsVerified();
        event(new \Illuminate\Auth\Events\Verified($user));

        return redirect('/login')->with('status', 'Correo verificado exitosamente. Si tu cuenta ya fue aprobada, puedes iniciar sesión.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
