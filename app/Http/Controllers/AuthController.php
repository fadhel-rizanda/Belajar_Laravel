<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        // dd($request); // buat ngecek apakahg controller berfungsi

        // validate, masukan kedalam variabel agar lebih efektif
        $fields = $request->validate([
            'username' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],// jadi unique ditulis users karena konfigurasi penamaan dalam databasenya sama sehingga teidak perlu dispecify
            'password' => ['required', 'min:3', 'confirmed'], // confirmed dapat terjadi jika penamaan input pada fenya adalah name_confirmation
        ]);

        // register
        $user = User::create($fields); // password automatically hashed

        // login
        Auth::login($user); // import yg facade
        event(new Registered($user));
        
        // redirect
        return redirect()->route('dashboard');
    }

    // login
    public function login(Request $request){
        // validate, masukan kedalam variabel agar lebih efektif
        $fields = $request->validate([            
            'email' => ['required', 'max:255', 'email'],// jadi unique ditulis users karena konfigurasi penamaan dalam databasenya sama sehingga teidak perlu dispecify
            'password' => ['required'], // confirmed dapat terjadi jika penamaan input pada fenya adalah name_confirmation
        ]);

        // try login
        if(Auth::attempt($fields, $request->remember)){ // ambil data remember dari request karena tidak msk ke fields
            return redirect()->intended('/dashboard'); // intended berarti setiap kali berhasil login maka akan kembali ke halaman sebelumnya atau ke halaman home
        }else{
            return back()->withErrors([
                'failed' => "Wrong credentials."
            ])->withInput($request->only('email'));
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate(); // buat token todak aktif yang didapatkan dari csrf
        $request->session()->regenerateToken(); // so the use of csrf is not only for storing a data inside cookie, but also securing the user data even though they dont have an data transaction inside the website
        return redirect()->route('posts.index');
    }

    // email notice handler
    public function verifyNotice(){
        return view('auth.verify-email');
    }

    public function verifyEmail (EmailVerificationRequest $request) {
        $request->fulfill();
     
        return redirect()->route('dashboard');
    }

    public function verifyHandler (Request $request) {
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with('message', 'Verification link sent!');
    }
}
