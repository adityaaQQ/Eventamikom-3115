<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login admin
     */
    public function showLogin() {
        return view('auth.login');
    }

    /**
     * Memproses verifikasi login admin / organizer
     */
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Memastikan hanya role admin, superadmin, atau organizer yang bisa masuk ke dashboard admin
            if (in_array($user->role, ['admin', 'superadmin', 'organizer'])) {
                return redirect()->intended(route('admin.dashboard'));
            }

            // Jika user biasa coba-coba login via portal admin, langsung logout & beri instruksi
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun Anda tidak memiliki hak akses sebagai admin / panitia.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda berikan tidak terdaftar di database kami.',
        ]);
    }

    /**
     * Memproses Log Out (Keluar)
     */
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}