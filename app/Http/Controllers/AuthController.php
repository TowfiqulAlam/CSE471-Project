<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    //show form for reg
    public function showRegister()
    {
        return view('auth.register');
    }

    // Reg
    public function register(Request $request)
    {

        $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|unique:users',
            'password'     => 'required|confirmed|min:6',
            'date_of_birth'=> 'required|date',
            'occupation'   => 'required|string',
            'user_type'    => 'required|in:job_seeker,employer',
        ]);

        $hashedPassword = Hash::make($request->password);

        DB::insert('INSERT INTO users (name, email, password, date_of_birth, occupation, user_type) VALUES (?, ?, ?, ?, ?, ?)', [
            $request->name,
            $request->email,
            $hashedPassword,
            $request->date_of_birth,
            $request->occupation,
            $request->user_type,
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();
        Auth::loginUsingId($user->id);

        return redirect('/dashboard');
    }

    //show login form
    public function showLogin()
    {
        return view('Auth.login');
    }

    // login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = DB::table('users')->where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::loginUsingId($user->id);
            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }

    // logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
