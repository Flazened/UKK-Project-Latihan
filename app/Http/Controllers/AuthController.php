<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function registerView()
    {
        return view('auth.register');
    }

    public function registerPost(Request $request){

        $validatedRequest = $request->validate([
           'name' => ['required', 'string'],
           'email' => ['required', 'string', 'email', 'unique:users,email'],
           'password' => ['required', 'string', 'confirmed', 'min:5'] 
        ]);
        
        User::create([
           'name' => $validatedRequest['name'],
           'email' => $validatedRequest['email'],
           'password' => bcrypt($validatedRequest['password']),
           'role' => 'dealer', 
        ]);

        return redirect()->route('login.view');
    }

    public function loginPost(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required'],
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('dealer.index');
        }
        
        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login-view');
    }
}
