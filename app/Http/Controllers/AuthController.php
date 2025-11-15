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
        // Jika user sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboard')->with('info', 'Anda sudah login. Silakan logout terlebih dahulu jika ingin login dengan akun lain.');
                case 'petugas':
                    return redirect()->route('petugas.dashboard')->with('info', 'Anda sudah login. Silakan logout terlebih dahulu jika ingin login dengan akun lain.');
                case 'pengguna':
                    return redirect()->route('user.dashboard')->with('info', 'Anda sudah login. Silakan logout terlebih dahulu jika ingin login dengan akun lain.');
                default:
                    Auth::logout();
                    return view('auth.login');
            }
        }
        
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
        // Jika user sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboard')->with('info', 'Anda sudah login. Silakan logout terlebih dahulu jika ingin mendaftar dengan akun lain.');
                case 'petugas':
                    return redirect()->route('petugas.dashboard')->with('info', 'Anda sudah login. Silakan logout terlebih dahulu jika ingin mendaftar dengan akun lain.');
                case 'pengguna':
                    return redirect()->route('user.dashboard')->with('info', 'Anda sudah login. Silakan logout terlebih dahulu jika ingin mendaftar dengan akun lain.');
                default:
                    Auth::logout();
                    return view('auth.register');
            }
        }
        
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