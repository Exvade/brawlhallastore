<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    // 1. Arahkan user ke halaman login Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Tangani data balikan dari Google
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan google_id ATAU email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if (!$user) {
                // Jika user belum ada, buat baru (Register otomatis)
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(), // Foto dari Google
                    'password' => null, // Tidak butuh password
                    'role' => 'member', // Default role
                ]);
            } else {
                // Jika user sudah ada tapi belum punya google_id (misal bekas login manual), update datanya
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                }
            }

            // Login-kan user tersebut ke dalam aplikasi
            Auth::login($user);

            // Redirect ke halaman dashboard user (Halaman Utama)
            return redirect()->intended('/');
        } catch (\Exception $e) {
            // Jika error / user membatalkan login
            return redirect('/')->with('error', 'Login Gagal atau Dibatalkan.');
        }
    }

    // 3. Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
