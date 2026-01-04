<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // 1. Arahkan user ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Google mengembalikan user ke sini setelah login sukses
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cek apakah user ini sudah pernah login sebelumnya?
            $finduser = User::where('google_id', $googleUser->id)->orWhere('email', $googleUser->email)->first();

            if($finduser){
                // Jika sudah ada, langsung login
                // Update google_id jika user lama login pakai email biasa sebelumnya
                if(empty($finduser->google_id)) {
                    $finduser->google_id = $googleUser->id;
                    $finduser->save();
                }
                
                Auth::login($finduser);
                return redirect()->intended('dashboard');
            }else{
                // Jika belum ada, buat user baru
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id'=> $googleUser->id,
                    'password' => Hash::make(Str::random(16)) // Password acak (karena login via google)
                ]);

                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }

        } catch (\Exception $e) {
            return redirect('login')->with('error', 'Login Google Gagal: ' . $e->getMessage());
        }
    }
}