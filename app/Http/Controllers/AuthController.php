<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // pastikan model User ada

class AuthController extends Controller
{
    // ✅ Form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ✅ Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboard');
                case 'petugas':
                    return redirect()->route('petugas.dashboard');
                case 'pengguna':
                    return redirect()->route('user.dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Role tidak dikenali.');
            }
        }

        return back()->withInput()->with('error', 'Email atau password salah.');
    }

    // ✅ Form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // ✅ Proses register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'pengguna', // default pengguna
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

    // ✅ Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}